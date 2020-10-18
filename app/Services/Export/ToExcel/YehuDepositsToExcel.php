<?php

namespace App\Services\Export\ToExcel;

use App\Company;
use App\Group;
use App\Loan;
use App\MpesaPaybill;
use App\User;
use App\UssdRegistration;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class YehuDepositsToExcel
{

	public function exportExcel($type, $data) {

        //get logged in user
        $user = auth()->user();

        //get paybills data sent via url
        $paybills = $data['paybills'];
        $paybills_array = [];

        if ($paybills) { $paybills_array[] = $paybills; }

        //paybills used to fetch remote data
        if (!count($paybills_array)) {
            $paybills_array = MpesaPaybill::where('company_id', '52')
                    ->pluck('paybill_number')
                    ->toArray();
        }

        //get paybills accounts for showing in dropdown
        $mpesapaybills = MpesaPaybill::where('company_id', '52')
                    ->get();

        //if records exist
        if (count($paybills_array)) {

            $paybills = implode(',', $paybills_array);
            $data['paybills'] = $paybills;
            $data['report'] = true;

            //get user transactions from paybills
            $yehudeposits_data = getLocalYehuDeposits($data);

            $yehudeposits_data_array = [];

            foreach ($yehudeposits_data->data as $yehudep) {

                $user_array = [];

                if ($yehudep->processed) { $processed = 'True'; } else  { $processed = 'False'; }

                $user_array['id'] = $yehudep->id;
                $user_array['bu_id'] = $yehudep->bu_id;
                $user_array['bu_nm'] = $yehudep->bu_nm;
                $user_array['acct_no'] = $yehudep->acct_no;
                $user_array['acct_name'] = $yehudep->acct_name;
                $user_array['full_name'] = $yehudep->full_name;
                $user_array['paybill'] = $yehudep->paybill_number;
                $user_array['phone'] = $yehudep->phone_number;
                $user_array['trans_id'] = $yehudep->trans_id;
                $user_array['processed'] = $processed;
                $user_array['processed_at'] = $yehudep->processed_at;
                $user_array['failed_at'] = $yehudep->failed_at;
                $user_array['created_at'] = $yehudep->created_at;
                $user_array['updated_at'] = $yehudep->updated_at;
                $user_array['updated_by'] = $yehudep->updated_by;

                $yehudeposits_data_array[] = $user_array;

            }

        } else {

            $yehudeposits_data_array = [];

        }

        //dd($yehudeposits_data_array);

        ////////////////
        //get sheets titles and other data
        $excel_name = "yehu_deposits";
        $excel_title = "Yehu Deposits";
        $excel_desc = "Yehu Deposits data";

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

        //if paybill has a value and it has no comma in between
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

        //if mpesaincoming data exists
        if (count($yehudeposits_data_array)) {

            // Initialize the array which will be passed into the Excel generator.
            $yehudepositsarray = [];

            // Define the Excel spreadsheet headers
            $yehudepositsarray[] =
                    [ 'ID', 'Bu ID','Bu Name','Account No', 'Account Name', 'Full Name', 'Paybill', 'Phone', 'Trans ID', 'Processed', 'Processed At', 'Failed At', 'Created At', 'Updated At', 'Updated By' ];

            $columns_number = count($yehudepositsarray[0]) - 1; //zero based array search

            // Convert each member of the returned collection into an array,
            // and append it to the array.
            foreach ($yehudeposits_data_array as $yehudeposits_data) {
                $yehudepositsarray[] = (array)$yehudeposits_data;
            }

            // Generate and return the spreadsheet
            $data_array = $yehudepositsarray;
            $data_type = $type;

            //download the file
            downloadExcelFile($excel_name, $excel_title, $excel_desc, $data_array, $data_type, $columns_number);

        }

	}

}
