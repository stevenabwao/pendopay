<?php

namespace App\Services\Export\ToExcel;

use App\Group;
use App\Loan;
use App\User;
use App\Services\Sms\SmsOutboxIndex;
use Illuminate\Support\Facades\DB;

class SmsOutboxExcel
{

	public function exportExcel($type, $data) {

        //dd($type, $data);
        //append report mode
        $data->merge([
            'report' => '1'
        ]);

        //get the data
        $dataIndex = new SmsOutboxIndex();
        $smsoutboxes = $dataIndex->getData($data);
        //dd(json_decode($result));
        //dd($smsoutboxes);
        $smsoutboxes_data = json_decode($smsoutboxes);

        dd($smsoutboxes_data);

        //format data
        //if records exist
        if (count($smsoutboxes_data->data)) {

            //get all the results
            //$smsoutboxes = json_decode($result);

            $account_data_array = [];

            foreach ($smsoutboxes as $account) {

                dd($account);

                $user_array = [];

                //$account = (Account) $account;
                //$account_obj = new DepositAccountHistory($account);

                $user_array['id'] = $account->id;
                $user_array['message'] = $account->msg_text;
                $user_array['phone'] = $dest;
                $user_array['status'] = $account->status;
                $user_array['created_at'] = formatExcelDate($account->finish_time);


                $account_data_array[] = $user_array;

            }

         } else {

            $account_data_array = [];

        }

        ////////////////
        //get sheets titles and other data
        $excel_name = "sms_outbox";
        $excel_title = "SMS Outbox";
        $excel_desc = "SMS Outbox";

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
                    ['id', 'message','phone','status','created_at'];

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
