<?php

namespace App\Services\Export\ToExcel;

use App\Company;
use App\User;
use App\UssdContactUs;
use App\UssdRecommend;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UssdContactUsToExcel
{

	public function exportExcel($type, $data) {

        //get logged in user
        $user = auth()->user();

        //get data
        if ($user->hasRole('superadministrator')){

            //get data
            $ussdcontactus = new UssdContactUs();

        } else if ($user->hasRole('administrator')){

            //get user company
            $user_company_id = $user->company->id;
            $ussdcontactus = UssdContactUs::where('company_id', $user_company_id);

        }

        //filter data
        $id = $data->id;
        $report = $data->report;
        $phone_number = $data->phone_number;
        $company_id = $data->company_id;
        $start_date = $data->start_date;
        if ($start_date) { $start_date = Carbon::parse($data->start_date); }
        $end_date = $data->end_date;
        if ($end_date) { $end_date = Carbon::parse($data->end_date); }

        //filter results
        if ($id) {
            $ussdcontactus = $ussdcontactus->where('id', $id);
        }
        if ($phone_number) {
            $ussdcontactus = $ussdcontactus->where('phone', $phone_number);
        }
        if ($company_id) {
            $ussdcontactus = $ussdcontactus->where('company_id', $company_id);
        }
        if ($start_date) {
            $ussdcontactus = $ussdcontactus->where('created_at', '>=', $start_date);
        }
        if ($end_date) {
            $ussdcontactus = $ussdcontactus->where('created_at', '<=', $end_date);
        }

        $ussdcontactus = $ussdcontactus->orderBy('created_at', 'desc');
        //end filter request

        //get all results
        $array_data = $ussdcontactus->get();

        //if records exist
        if (count($array_data)) {

            $array_data_array = [];

            foreach ($array_data as $singledata) {

                $user_array = [];

                $user_array['id'] = $singledata->id;
                $user_array['company'] = $singledata->company->name;
                $user_array['phone'] = $singledata->phone;
                $user_array['message'] = $singledata->message;
                $user_array['created_at'] = $singledata->created_at;

                $array_data_array[] = $user_array;

            }

        } else {

            $array_data_array = [];

        }

        ////////////////
        //get sheets titles and other data
        $excel_name = "ussd_contactus";
        $excel_title = "USSD Contact Us";
        $excel_desc = "USSD Contact Us data";

        //search params - for filtering records based on search criteria
        $id = $data->id;
        $start_date = $data->start_date;
        $end_date = $data->end_date;
        $start_at_date = $start_date;
        $end_at_date = $end_date;
        $phone = $data->phone;
        $company_id = $data->company_id;

        if ($id) {
            $excel_name .= "_id_" . $id;
            $excel_title .= "_id_" . $id;
        }

        if ($start_date) {
            $excel_name .= "_from_" . $start_at_date;
            $excel_title .= "_from_" . $start_at_date;
        }

        if ($end_date) {
            $excel_name .= "_to_" . $end_at_date;
            $excel_title .= "_to_" . $end_at_date;
        }

        if ($phone) {
            $excel_name .= "_phone_" . $phone;
            $excel_title .= "_phone_" . $phone;
        }

        if ($company_id) {
            $company_data = Company::find($company_id);
            $company_name = $company_data->name;
            $excel_name .= "_company_" . $company_name;
            $excel_title .= "_company_" . $company_name;
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
                    ['ID', 'Company', 'User Phone', 'Message', 'Created At'];

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
