<?php

namespace App\Services\Export\ToExcel;

use App\Group;
use App\Loan;
use App\MpesaPaybill;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MpesaIncomingToExcel
{

	public function exportExcel($type, $data) {

        //get logged in user
        $user = auth()->user();

        //get paybills data sent via url
        $paybills = $data['paybills'];
        $paybills_array = [];

        if ($paybills) { $paybills_array[] = $paybills; }

        //get account paybills
        if ($user->hasRole('superadministrator')){

            //paybills used to fetch remote data
            if (!count($paybills_array)) {
                //get all paybills
                $paybills_array = MpesaPaybill::pluck('paybill_number')
                        ->toArray();
            }

            //get paybills accounts for showing in dropdown
            $mpesapaybills = MpesaPaybill::all();

        } else if ($user->hasRole('administrator')){

            //get user company
            $user_company_id = $user->company->id;

            //paybills used to fetch remote data
            if (!count($paybills_array)) {
                $paybills_array = MpesaPaybill::where('company_id', $user_company_id)
                        ->pluck('paybill_number')
                        ->toArray();
            }

            //get paybills accounts for showing in dropdown
            $mpesapaybills = MpesaPaybill::where('company_id', $user_company_id)
                        ->get();

        }

        //if records exist
        if (count($paybills_array)) {

            $paybills = implode(',', $paybills_array);
            $data['paybills'] = $paybills;
            $data['report'] = true;

            //get user transactions from paybills
            $mpesaincoming_data = getMpesaPayments($data);

            $mpesaincoming_data_array = [];

            //dd($data, $paybills_array, $mpesaincoming_data);

            foreach ($mpesaincoming_data->data as $mpesain) {

                $user_array = [];
                $first_name = $mpesain->first_name;
                $middle_name = $mpesain->middle_name;
                $last_name = $mpesain->last_name;

                $user_array['id'] = $mpesain->id;
                $user_array['name'] = titlecase($first_name . " ". $middle_name . " ". $last_name);
                $user_array['phone'] = $mpesain->msisdn;
                $user_array['trans_id'] = $mpesain->trans_id;
                $user_array['account'] = $mpesain->bill_ref;
                $user_array['amount'] = formatExcelFloat($mpesain->trans_amount);
                $user_array['paybill_no'] = $mpesain->biz_no;
                $user_array['paybill_name'] = getPaybillName($mpesain->biz_no);
                $user_array['created_at'] = $mpesain->date_stamp;

                $mpesaincoming_data_array[] = $user_array;

            }

        } else {

            $mpesaincoming_data_array = [];

        }

        ////////////////
        //get sheets titles and other data
        $excel_name = "mpesa_incoming";
        $excel_title = "Mpesa Incoming";
        $excel_desc = "Mpesa Incoming data";

        //search params - for filtering records based on search criteria
        $start_date = $data->start_date;
        $end_date = $data->end_date;
        $user_id = $data->user_id;
        $start_at_date = formatDisplayDate($start_date);
        $end_at_date = formatDisplayDate($end_date);

        if ($start_date) {
            //get excel titles
            $excel_name .= "_from_" . $start_at_date;
            $excel_title .= "_from_" . $start_at_date;
        }

        if ($end_date) {
            //get excel titles
            $excel_name .= "_to_" . $end_at_date;
            $excel_title .= "_to_" . $end_at_date;
        }

        //if paybills has a value and it has no comma in between
        //comma signifies default paybills being searched, not user selected
        if ($paybills && (!checkCharExists(',', $paybills))) {
            //get excel titles
            $excel_name .= "_paybills_" . $paybills;
            $excel_title .= "_paybills_" . $paybills;
        }
        //end search params

        //format excel name
        $excel_name = getStrSlug($excel_name);
        /////////////////


        //dd($mpesaincoming_data_array, $excel_name);

        //if mpesaincoming data exists
        if (count($mpesaincoming_data_array)) {

            // Initialize the array which will be passed into the Excel generator.
            $mpesaincomingArray = [];

            // Define the Excel spreadsheet headers
            $mpesaincomingArray[] =
                    ['id', 'name','phone','trans_id', 'account', 'amount', 'paybill_no', 'paybill_name', 'created_at'];

            $columns_number = count($mpesaincomingArray[0]) - 1; //zero based array search

            // Convert each member of the returned collection into an array,
            // and append it to the array.
            foreach ($mpesaincoming_data_array as $mpesaincoming_data) {
                $mpesaincomingArray[] = (array)$mpesaincoming_data;
            }

            // Generate and return the spreadsheet
            $data_array = $mpesaincomingArray;
            $data_type = $type;

            //download the file
            downloadExcelFile($excel_name, $excel_title, $excel_desc, $data_array, $data_type, $columns_number);

        }

	}

}
