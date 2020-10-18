<?php

namespace App\Services\Export\ToExcel;

use App\Company;
use App\Group;
use App\Loan;
use App\User;
use App\UssdEvent;
use App\UssdRegistration;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UssdEventsToExcel
{

	public function exportExcel($type, $data) {

        //get logged in user
        $user = auth()->user();

        //get data
        if ($user->hasRole('superadministrator')){

            //get data
            $ussdevents = new UssdEvent();

        } else if ($user->hasRole('administrator')){

            //get user company
            $user_company_id = $user->company->id;

            $ussdevents = UssdEvent::where('company_id', $user_company_id);

        }

        //filter data
        $id = $data->id;
        $company_id = $data->company_id;
        $status_id = $data->status_id;
        $start_date = $data->start_date;
        if ($start_date) { $start_date = Carbon::parse($data->start_date); }
        $end_date = $data->end_date;
        if ($end_date) { $end_date = Carbon::parse($data->end_date); }

        //filter results
        if ($id) {
            $ussdevents = $ussdevents->where('id', $id);
        }
        if ($status_id) {
            $ussdevents = $ussdevents->where('status_id', $status_id);
        }
        if ($company_id) {
            $ussdevents = $ussdevents->where('company_id', $company_id);
        }
        if ($start_date) {
            $ussdevents = $ussdevents->where('created_at', '>=', $start_date);
        }
        if ($end_date) {
            $ussdevents = $ussdevents->where('created_at', '<=', $end_date);
        }

        $ussdevents = $ussdevents->orderBy('created_at', 'desc');

        //get all results
        $array_data = $ussdevents->get();

        //if records exist
        if (count($array_data)) {

            $array_data_array = [];

            foreach ($array_data as $singledata) {

                $user_array = [];

                $user_array['id'] = $singledata->id;
                $user_array['name'] = $singledata->name;
                $user_array['company'] = $singledata->company->name;
                $user_array['amount'] = $singledata->amount;
                $user_array['status'] = $singledata->eventstatus->name;
                $user_array['start_at'] = $singledata->start_at;
                $user_array['end_at'] = $singledata->end_at;
                $user_array['created_at'] = $singledata->created_at;

                $array_data_array[] = $user_array;

            }

        } else {

            $array_data_array = [];

        }

        //dd($ussdregistration_data_array);

        ////////////////
        //get sheets titles and other data
        $excel_name = "ussd_events";
        $excel_title = "USSD Events";
        $excel_desc = "USSD Events data";

        //search params - for filtering records based on search criteria
        $start_date = $data->start_date;
        $end_date = $data->end_date;
        $user_id = $data->user_id;
        $start_at_date = $start_date;
        $end_at_date = $end_date;

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
                    ['ID', 'Event Name','Company','Amount', 'Status', 'Start At', 'End At', 'created_at'];

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
