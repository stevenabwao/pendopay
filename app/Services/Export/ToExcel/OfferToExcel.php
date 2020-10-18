<?php

namespace App\Services\Export\ToExcel;

use App\Entities\Company;
use App\Entities\Offer;
use App\Entities\Status;
use App\Services\Offer\OfferIndex;

class OfferToExcel
{

	public function exportExcel($type, $data) {

        //append report mode
        $data->merge([
            'report' => '1'
        ]);

        //get the data
        $accountIndex = new OfferIndex();
        $result = $accountIndex->getData($data);

        //get all the results
        $accounts = $result->get();

        //dd($accounts);

        //if records exist
        if (count($accounts)) {

            //get required columns
            $accounts = $accounts->map(function ($item) {
              return [
                'id' => $item['id'],
                'gl_account_no' => $item['gl_account_no'],
                'ledger_balance' => $item['ledger_balance'],
                'last_activity_date' => $item['last_activity_date'],
                'company_id' => $item['company_id'],
                'status_id' => $item['status_id'],
                'created_at' => $item['created_at']
              ];
            });

            $account_data_array = [];

            foreach ($accounts as $account) {

                $user_array = [];

                // hydrate result
                $account_obj = new Offer($account);

                $company_name = "";
                if ($account_obj->company){
                    $company_name = $account_obj->company->name;
                }

                $account_name = "";
                if ($account_obj->glaccount){
                    $account_name = $account_obj->glaccount->description;
                }

                $user_array['id'] = $account['id'];
                $user_array['gl_account_no'] = $account['gl_account_no'];
                $user_array['account_name'] = titlecase($account_name);
                $user_array['ledger_balance'] = formatExcelFloat($account_obj->ledger_balance);
                $user_array['last_activity_date'] = formatExcelDate($account_obj->last_activity_date);
                $user_array['company'] = $company_name;
                $user_array['created_at'] = formatExcelDate($account_obj->created_at);

                $account_data_array[] = $user_array;

            }

        } else {

            $account_data_array = [];

        }

        //dd($account_data_array);

        ////////////////
        //get sheets titles and other data
        $excel_name = "offers";
        $excel_title = "Offers";
        $excel_desc = "Offers";

        //search params - for filtering records based on search criteria
        $start_date = $data->start_date;
        $end_date = $data->end_date;
        $group_id = $data->group_id;
        $status_id = $data->status_id;
        $companies = $data->companies;
        $account_search = $data->account_search;
        $user_id = $data->user_id;

        if ($account_search) {
            $excel_name .= "_account_search_" . $account_search;
            $excel_title .= "_account_search_" . $account_search;
        }


        if ($companies) {
            $companies_array = explode(',', $companies);//dd($companies_array);
            $company_data = Company::whereIn('id', $companies_array)->first();
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
                    ['ID', 'Acct No','Acct Name','Ledger Balance', 'Last Activity Date', 'Company/ Sacco', 'Created At'];

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
