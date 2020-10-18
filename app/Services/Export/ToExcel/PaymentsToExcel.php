<?php

namespace App\Services\Export\ToExcel;

use App\Services\Payment\PaymentIndex;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentsToExcel
{

	public function exportExcel($type, $data) {

        //dd($type, $data->all());
        //get data
        $paymentIndex = new PaymentIndex();
        $array_data = $paymentIndex->getData($data);
        $array_data = $array_data->get();
        //dd($array_data);

        //if records exist
        if (count($array_data)) {

            $array_data_array = [];

            foreach ($array_data as $singledata) {

                $user_array = [];

                if ($singledata->processed) {
                    $processed = "True";
                } else {
                    $processed = "False";
                }

                $user_array['id'] = $singledata->id;
                $user_array['company'] = $singledata->company_name;
                $user_array['account_no'] = $singledata->account_no;
                $user_array['account_name'] = $singledata->account_name;
                $user_array['phone'] = $singledata->phone;
                $user_array['trans_id'] = $singledata->trans_id;
                $user_array['full_name'] = titlecase($singledata->full_name);
                $user_array['amount'] = formatExcelFloat($singledata->amount);
                $user_array['paybill_number'] = $singledata->paybill_number;
                $user_array['processed'] = $processed;
                $user_array['created_at'] = formatExcelDate($singledata->created_at);

                $array_data_array[] = $user_array;

            }

        } else {

            $array_data_array = [];

        }

        ////////////////
        //get sheets titles and other data
        $excel_name = "payments";
        $excel_title = "Payments";
        $excel_desc = "Payments data";

        //search params - for filtering records based on search criteria
        $report = $data->report;
        $id = $data->id;
        $paybills = $data->paybills;
        $companies = $data->companies;
        $status_id = $data->status_id;
        $created_by = $data->created_by;
        $updated_by = $data->updated_by;
        $order_by = $data->order_by;
        $order_style = $data->order_style;
        $start_date = $data->start_date;
        $end_date = $data->end_date;
        $account_search = $data->account_search;


        if ($id) {
            $excel_name .= "_id_" . $id;
            $excel_title .= "_id_" . $id;
        }

        if ($account_search) {
            $excel_name .= "_account_search_" . $account_search;
            $excel_title .= "_account_search_" . $account_search;
        }

        if ($start_date) {
            $excel_name .= "_from_" . $start_date;
            $excel_title .= "_from_" . $start_date;
        }

        if ($end_date) {
            $excel_name .= "_to_" . $end_date;
            $excel_title .= "_to_" . $end_date;
        }

        if ($paybills) {
            $excel_name .= "_paybills_" . $paybills;
            $excel_title .= "_paybills_" . $paybills;
        }

        if ($companies) {
            $company_data = Company::find($companies);
            $company_name = $company_data->name;
            $excel_name .= "_company_" . $company_name;
            $excel_title .= "_company_" . $company_name;
        }

        //format excel name
        $excel_name = getStrSlug($excel_name);
        /////////////////

        //dd($excel_name);


        //dd($array_data_array, $excel_name);

        //if mpesaincoming data exists
        if (count($array_data_array)) {

            // Initialize the array which will be passed into the Excel generator.
            $thedata_array = [];

            // Define the Excel spreadsheet headers
            $thedata_array[] =
                    ['ID', 'Company', 'Account No', 'Account Name', 'Phone', 'Trans ID',
                    'Full Name', 'Amount', 'Paybill',  'Processed', 'Created At'];

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
