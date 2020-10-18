<?php

namespace App\Services\Export\ToExcel;

use App\Entities\SupervisorClientAssignDetail;
use App\Entities\Company;
use App\Entities\CompanyUser;
use App\Entities\Status;
use App\Entities\Product;
use App\Services\SupervisorClientAssign\SupervisorClientAssignDetailIndex;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SupervisorClientsToExcel
{

	public function exportExcel($type, $data) {

        $status_active = config('constants.status.active');
        $status_inactive = config('constants.status.inactive');

        //append report mode
        $data->merge([
            'report' => '1'
        ]);

        //get the data
        $accountIndex = new SupervisorClientAssignDetailIndex();
        $result = $accountIndex->getData($data);

        //get all the results
        $accounts = $result->get();

        //dd($accounts);

        //if records exist
        if (count($accounts)) {

            $account_data_array = [];

            foreach ($accounts as $account) {

                //dd($account);

                $user_array = [];

                $full_names = '';
                $phone = '';
                $contributions = '';
                $created_at = '';
                $registered_at = '';
                $supervisor_names = '';
                $company = '';
                $status = '';
                $assigned_at = '';

                if ($account->companyuser) {
                    if ($account->companyuser->user) {
                        $full_names = $account->companyuser->user->first_name;
                        $full_names .= " " . $account->companyuser->user->last_name;
                    }
                }
                $full_names = titlecase($full_names);

                if ($account->companyuser) {
                    if ($account->companyuser->user) {
                        $phone = $account->companyuser->user->phone;
                    }
                }

                if ($account->companyuser) {
                    if ($account->companyuser->depositaccountsummary) {
                        if ($account->companyuser->depositaccountsummary->ledger_balance) {
                            $contributions = $account->companyuser->depositaccountsummary->ledger_balance;
                        }
                    } else {
                        $contributions = 0;
                    }
                }

                $created_at = formatFriendlyDate($account->companyuser->created_at);

                if ($account->companyuser->registration_paid_date) {
                    $registered_at = formatFriendlyDate($account->companyuser->registration_paid_date);
                } else {
                    $registered_at = "Not Paid";
                }

                if ($account->company) {
                    $company = $account->company->name;
                }

                if ($account->company_supervisor_id) {
                    $company_user_data = CompanyUser::find($account->company_supervisor_id);
                    $supervisor_names = $company_user_data->user->first_name . " " . $company_user_data->user->first_name;
                }

                if ($account->companyuser->registration_paid == "1") {
                    $status = "Active";
                } else {
                    $status = "Inactive";
                }

                $assigned_at = formatFriendlyDate($account->created_at);

                //dd($full_names, $phone, $contributions, $created_at, $registered_at, $company, $status, $assigned_at);

                $user_array['full_names'] = $full_names;
                $user_array['phone'] = $phone;
                $user_array['contributions'] = formatExcelFloat($contributions);
                $user_array['supervisor'] = $supervisor_names;
                $user_array['company'] = $company;
                $user_array['created_at'] = formatExcelDate($created_at);
                if ($registered_at == "Not Paid") {
                    $user_array['registered_at'] = $registered_at;
                } else {
                    $user_array['registered_at'] = formatExcelDate($registered_at);
                }
                $user_array['assigned_at'] = formatExcelDate($assigned_at);
                $user_array['status'] = $status;


                $account_data_array[] = $user_array;

            }

        } else {

            $account_data_array = [];

        }

        //dd($account_data_array);

        ////////////////
        //get sheets titles and other data
        $excel_name = "supervisor_clients";
        $excel_title = "Supervisor Clients";
        $excel_desc = "Supervisor Clients";

        //search params - for filtering records based on search criteria
        $start_date = $data->start_date;
        $end_date = $data->end_date;
        $company_supervisor_id = $data->company_supervisor_id;
        $status_id = $data->status_id;
        $company_id = $data->company_id;
        $account_search = $data->account_search;
        $user_id = $data->user_id;

        if ($account_search) {
            $excel_name .= "_account_search_" . $account_search;
            $excel_title .= "_account_search_" . $account_search;
        }

        if ($company_supervisor_id) {
            $company_user_data = CompanyUser::find($company_supervisor_id);
            $supervisor_full_names = $company_user_data->user->first_name . " " . $company_user_data->user->first_name;
            $excel_name .= "_supervisor_" . $supervisor_full_names;
            $excel_title .= "_supervisor_" . $supervisor_full_names;
        }

        if ($company_id) {
            $company_data = Company::find($company_id);
            $excel_name .= "_company_" . $company_data->name;
            $excel_title .= "_company_" . $company_data->name;
        }

        if ($status_id == $status_active) {
            $excel_name .= "_status_active";
            $excel_title .= "_status_active";
        }
        if ($status_id == $status_inactive) {
            $excel_name .= "_status_inactive";
            $excel_title .= "_status_inactive";
        }

        if ($start_date) {
            //get excel titles
            $excel_name .= "_from_" . $start_date;
            $excel_title .= "_from_" . $start_date;
        }

        if ($end_date) {
            //get excel titles
            $excel_name .= "_to_" . $end_date;
            $excel_title .= "_to_" . $end_date;
        }

        //end search params

        //format excel name
        $excel_name = getStrSlug($excel_name);
        /////////////////

        //dd($account_data_array);

        //if mpesaincoming data exists
        if (count($account_data_array)) {

            // Initialize the array which will be passed into the Excel generator.
            $accountArray = [];

            $accountArray[] =
                    ['Full Names', 'Phone','Savings', 'Supervisor', 'Company', 'Created At', 'Registered At', 'Assigned At', 'Status'];

            $columns_number = count($accountArray[0]) - 1; //zero based array search

            // Convert each member of the returned collection into an array,
            // and append it to the array.
            foreach ($account_data_array as $account_data) {
                $accountArray[] = (array)$account_data;
            }

            // Generate and return the spreadsheet
            $data_array = $accountArray;
            $data_type = $type;

            //download the file
            downloadExcelFile($excel_name, $excel_title, $excel_desc, $data_array, $data_type, $columns_number);

        }

	}

}
