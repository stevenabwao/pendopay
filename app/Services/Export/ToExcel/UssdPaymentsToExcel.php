<?php

namespace App\Services\Export\ToExcel;

use App\Company;
use App\Group;
use App\Loan;
use App\User;
use App\UssdEvent;
use App\UssdPayment;
use App\UssdRegistration;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UssdPaymentsToExcel
{

	public function exportExcel($type, $data) {

        //get logged in user
        $user = auth()->user();

        //get data
        if ($user->hasRole('superadministrator')){

            //get data
            $ussdpayments = new UssdPayment();

        } else if ($user->hasRole('administrator')){

            //get user company
            $user_company_id = $user->company->id;

            $ussdpayments = UssdPayment::select('ussd_payments.*')
                    ->join('ussd_events' , 'ussd_payments.ussd_event_id' ,'=' , 'ussd_events.id')
                    ->where('ussd_events.company_id', $user_company_id);

        }

        //filter data
        $id = $data->id;
        $report = $data->report;
        $phone_number = $data->phone_number;
        $ussd_event_id = $data->ussd_event_id;
        $start_date = $data->start_date;
        if ($start_date) { $start_date = Carbon::parse($data->start_date); }
        $end_date = $data->end_date;
        if ($end_date) { $end_date = Carbon::parse($data->end_date); }

        //filter results
        if ($id) {
            $ussdpayments = $ussdpayments->where('ussd_payments.id', $id);
        }
        if ($phone_number) {
            $ussdpayments = $ussdpayments->where('ussd_payments.phone', $phone_number);
        }
        if ($ussd_event_id) {
            $ussdpayments = $ussdpayments->where('ussd_payments.ussd_event_id', $ussd_event_id);
        }
        if ($start_date) {
            $ussdpayments = $ussdpayments->where('ussd_payments.created_at', '>=', $start_date);
        }
        if ($end_date) {
            $ussdpayments = $ussdpayments->where('ussd_payments.created_at', '<=', $end_date);
        }

        $ussdpayments = $ussdpayments->orderBy('ussd_payments.created_at', 'desc');
        //end filter request

        //get all results
        $array_data = $ussdpayments->get();

        //if records exist
        if (count($array_data)) {

            $array_data_array = [];

            foreach ($array_data as $singledata) {

                $user_array = [];

                $phone = $singledata->phone;
                $ussd_event_id = $singledata->ussd_event_id;

                //get user full name
                //DB::enableQueryLog();
                $ussd_registration_data = $singledata->ussdevent->ussdregistrations
                             ->where('phone', $phone)
                             ->first();
                if ($ussd_registration_data) {
                    $full_name = $ussd_registration_data->name;
                } else {
                    $full_name = "";
                }
                /*print_r(DB::getQueryLog());*/
                $user_array['id'] = $singledata->id;
                $user_array['company'] = $singledata->ussdevent->company->name;
                $user_array['full_name'] = $full_name;
                $user_array['event_name'] = $singledata->ussdevent->name;
                $user_array['phone'] = $phone;
                $user_array['amount'] = $singledata->amount;
                $user_array['mpesa_trans_id'] = $singledata->mpesa_trans_id;
                $user_array['created_at'] = $singledata->created_at;

                $array_data_array[] = $user_array;

            }

        } else {

            $array_data_array = [];

        }

        ////////////////
        //get sheets titles and other data
        $excel_name = "ussd_payments";
        $excel_title = "USSD Payments";
        $excel_desc = "USSD Payments data";

        //search params - for filtering records based on search criteria
        $start_date = $data->start_date;
        $end_date = $data->end_date;
        $start_at_date = $start_date;
        $end_at_date = $end_date;
        $phone_number = $data->phone_number;
        $ussd_event_id = $data->ussd_event_id;

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

        if ($phone_number) {
            //get excel titles
            $excel_name .= "_phone_" . $phone_number;
            $excel_title .= "_phone_" . $phone_number;
        }

        if ($ussd_event_id) {
            //get event name
            $ussd_event_data = UssdEvent::find($ussd_event_id);
            $event_name = $ussd_event_data->name;
            $excel_name .= "_event_" . $event_name;
            $excel_title .= "_event_" . $event_name;
        }

        //format excel name
        $excel_name = getStrSlug($excel_name);
        /////////////////


        //dd($array_data_array, $excel_name);

        //if mpesaincoming data exists
        if (count($array_data_array)) {

            // Initialize the array which will be passed into the Excel generator.
            $thedata_array = [];

            // Define the Excel spreadsheet headers
            $thedata_array[] =
                    ['ID', 'Company', 'Client Name', 'Event Name','Phone', 'Amount', 'Trans ID', 'Created At'];

            $columns_number = count($thedata_array[0]) - 1; //zero based array search

            // Convert each member of the returned collection into an array,
            // and append it to the array.
            foreach ($array_data_array as $the_data) {
                $thedata_array[] = (array)$the_data;
            }

            // Generate and return the spreadsheet
            $data_array = $thedata_array;
            $data_type = $type;

            //download the file
            downloadExcelFile($excel_name, $excel_title, $excel_desc, $data_array, $data_type, $columns_number);

        }

	}

}
