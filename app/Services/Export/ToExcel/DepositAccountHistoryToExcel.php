<?php

namespace App\Services\Export\ToExcel;

use App\Entities\DepositAccountHistory;
use App\Entities\Company;
use App\Entities\Group;
use App\Entities\Status;
use App\Entities\Product;
use App\Services\DepositAccountHistory\DepositAccountHistoryIndex;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DepositAccountHistoryToExcel
{

	public function exportExcel($type, $data) {

        //append report mode
        $data->merge([
            'report' => '1'
        ]);

        //get the data
        $accountIndex = new DepositAccountHistoryIndex();
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

                //$account = (Account) $account;
                //$account_obj = new DepositAccountHistory($account);

                $company_name = '';
                if ($account->company){
                    $company_name = $account->company->name;
                }
                $account_name = '';
                if ($account->depositaccountsummary){
                    if ($account->depositaccountsummary->depositaccount){
                        $account_name = titlecase($account->depositaccountsummary->depositaccount->account_name);
                    }
                }

                $user_array['id'] = $account->id;
                $user_array['account_no'] = $account->account_no;
                $user_array['account_name'] = titlecase($account_name);
                $user_array['amount'] = formatExcelFloat($account->amount);
                $user_array['company'] = $company_name;
                $user_array['created_at'] = formatExcelDate($account->created_at);


                $account_data_array[] = $user_array;

            }

        } else {

            $account_data_array = [];

        }

        //dd($account_data_array);

        ////////////////
        //get sheets titles and other data
        $excel_name = "deposit_accounts_history";
        $excel_title = "Deposit Accounts History";
        $excel_desc = "Deposit Accounts History";

        //search params - for filtering records based on search criteria
        $start_date = $data->start_date;
        $end_date = $data->end_date;
        $group_id = $data->group_id;
        $status_id = $data->status_id;
        $company_id = $data->company_id;
        $account_search = $data->account_search;
        $user_id = $data->user_id;

        if ($account_search) {
            $excel_name .= "_account_search_" . $account_search;
            $excel_title .= "_account_search_" . $account_search;
        }

        if ($company_id) {
            $company_data = Company::find($company_id);
            $excel_name .= "_company_" . $company_data->name;
            $excel_title .= "_company_" . $company_data->name;
        }

        if ($status_id) {
            $status_data = Status::find($status_id);
            $excel_name .= "_status_" . $status_data->name;
            $excel_title .= "_status_" . $status_data->name;
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
                    ['ID', 'Acct No','Acct Name','Amount', 'Company/ Sacco', 'Created At'];

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
