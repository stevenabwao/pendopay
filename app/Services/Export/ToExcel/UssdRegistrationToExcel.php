<?php

namespace App\Services\Export\ToExcel;

use App\Company;
use App\Group;
use App\Loan;
use App\User;
use App\UssdRegistration;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UssdRegistrationToExcel
{

	public function exportExcel($type, $data) {

        //get logged in user
        $user = auth()->user();

        //get data
        if ($user->hasRole('superadministrator')){

            //get data
            $ussdregistrations = new UssdRegistration();

        } else if ($user->hasRole('administrator')){

            //get user company
            $user_company_id = $user->company->id;

            //get paybills accounts for showing in dropdown
            $ussdregistrations = UssdRegistration::where('company_id', $user_company_id);

        }

        //filter request
        $id = $data->id;
        $report = $data->report;
        $phone_number = $data->phone_number;
        $account_name = $data->account_name;
        $start_date = $data->start_date;
        $company_id = $data->company_id;
        $lipanampesacode = $data->lipanampesacode;
        if ($start_date) { $start_date = Carbon::parse($data->start_date); }
        $end_date = $data->end_date;
        if ($end_date) { $end_date = Carbon::parse($data->end_date); }

        //filter results
        if ($id) {
            $ussdregistrations = $ussdregistrations->where('id', $id);
        }
        if ($company_id) {
            $ussdregistrations = $ussdregistrations->where('company_id', $company_id);
        }
        if ($phone_number) {
            //format the phone number
            $phone_number = formatPhoneNumber($phone_number);
            $ussdregistrations = $ussdregistrations->where('mobile', $phone_number);
        }
        if ($lipanampesacode) {
            $ussdregistrations = $ussdregistrations->whereIn('lipanampesacode', $lipanampesacode);
        }
        if ($account_name) {
            $ussdregistrations = $ussdregistrations->where('name', $account_name);
        }
        if ($start_date) {
            $ussdregistrations = $ussdregistrations->where('created_at', '>=', $start_date);
        }
        if ($end_date) {
            $ussdregistrations = $ussdregistrations->where('created_at', '<=', $end_date);
        }

        $ussdregistrations = $ussdregistrations->orderBy('created_at', 'desc');

        //get all results
        $ussdregistrations = $ussdregistrations->get();

        //if records exist
        if (count($ussdregistrations)) {

            $ussdregistration_data_array = [];

            foreach ($ussdregistrations as $ussdreg) {

                $user_array = [];

                $user_array['id'] = $ussdreg->id;
                $user_array['name'] = $ussdreg->name;
                $user_array['mobile'] = $ussdreg->mobile;
                $user_array['alternate_mobile'] = $ussdreg->alternate_mobile;
                $user_array['tsc_no'] = $ussdreg->tsc_no;
                $user_array['event'] = $ussdreg->ussdevent->name;
                $user_array['email'] = $ussdreg->email;
                $user_array['county'] = $ussdreg->county;
                $user_array['sub_county'] = $ussdreg->sub_county;
                $user_array['workplace'] = $ussdreg->workplace;
                $user_array['ict_level'] = $ussdreg->ict_level;
                $user_array['subjects'] = $ussdreg->subjects;
                $user_array['lipanampesacode'] = $ussdreg->lipanampesacode;
                $user_array['registered'] = $ussdreg->registered;
                $user_array['created_at'] = $ussdreg->created_at;

                $ussdregistration_data_array[] = $user_array;

            }

        } else {

            $ussdregistration_data_array = [];

        }

        //dd($ussdregistration_data_array);

        ////////////////
        //get sheets titles and other data
        $excel_name = "ussd_registrations";
        $excel_title = "USSD Registration";
        $excel_desc = "USSD Registration data";

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

        //if lipanampesacode has a value and it has no comma in between
        //comma signifies default lipanampesacode being searched, not user selected
        if ($lipanampesacode && (!checkCharExists(',', $lipanampesacode))) {
            //get excel titles
            $excel_name .= "_lipanampesacode_" . $lipanampesacode;
            $excel_title .= "_lipanampesacode_" . $lipanampesacode;
        }
        //end search params

        //format excel name
        $excel_name = getStrSlug($excel_name);
        /////////////////


        //dd($ussdregistration_data_array, $excel_name);

        //if mpesaincoming data exists
        if (count($ussdregistration_data_array)) {

            // Initialize the array which will be passed into the Excel generator.
            $ussdregistrationArray = [];

            // Define the Excel spreadsheet headers
            $ussdregistrationArray[] =
                    ['id', 'name','phone','Alternate Phone', 'TSC No', 'Event', 'Email', 'County', 'Sub-County', 'Work Place', 'ICT Level', 'Subjects', 'LipaNaMpesa Code', 'Registered',  'created_at'];

            $columns_number = count($ussdregistrationArray[0]) - 1; //zero based array search

            // Convert each member of the returned collection into an array,
            // and append it to the array.
            foreach ($ussdregistration_data_array as $ussdregistration_data) {
                $ussdregistrationArray[] = (array)$ussdregistration_data;
            }

            // Generate and return the spreadsheet
            $data_array = $ussdregistrationArray;
            $data_type = $type;

            //download the file
            downloadExcelFile($excel_name, $excel_title, $excel_desc, $data_array, $data_type, $columns_number);

        }

	}

}
