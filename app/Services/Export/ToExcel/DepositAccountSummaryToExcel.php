<?php

namespace App\Services\Export\ToExcel;

use App\Entities\DepositAccountSummary;
use App\Entities\Company;
use App\Entities\Group;
use App\Entities\Status;
use App\Entities\Product;
use App\Services\DepositAccountSummary\DepositAccountSummaryIndex;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DepositAccountSummaryToExcel
{

	public function exportExcel($type, $data) {

        //append report mode
        $data->merge([
            'report' => '1'
        ]);

        //get the data
        $accountIndex = new DepositAccountSummaryIndex();
        $result = $accountIndex->getData($data);

        //get all the results
        $accounts = $result->get();

        //dd($accounts);

        //if records exist
        if (count($accounts)) {

            //get required columns
            /*
            $accounts = $accounts->map(function ($item) {
              return [
                'id' => $item['id'],
                'account_no' => $item['account_no'],
                'last_deposit_date' => $item['last_deposit_date'],
                'ledger_balance' => $item['ledger_balance'],
                'last_deposit_amount' => $item['last_deposit_amount'],
                'company_name' => $item['company_name'],
                'status_id' => $item['status_id'],
                'account_name' => ucwords(strtolower($item['account_name'])),
                'created_at' => $item['created_at']
              ];
            });
            */

            $account_data_array = [];

            foreach ($accounts as $account) {

                //dd($account->id);

                $user_array = [];

                //$account = (Account) $account;
                //$account_obj = new DepositAccountSummary($account);

                /*$user_array['id'] = $account['id'];
                $user_array['account_no'] = $account['account_no'];
                $user_array['account_name'] = $account['account_name'];
                $user_array['last_deposit_date'] = $account['last_deposit_date'];
                $user_array['ledger_balance'] = $account['ledger_balance'];
                $user_array['last_deposit_amount'] = $account['last_deposit_amount'];
                $user_array['company'] = $account['company_name'];
                $user_array['created_at'] = $account['created_at'];
                */

                $company_name = '';
                if ($account->company){
                    $company_name = $account->company->name;
                }
                $account_name = '';
                if ($account->depositaccount){
                    $account_name = $account->depositaccount->account_name;
                }

                $user_array['id'] = $account->id;
                $user_array['account_no'] = $account->account_no;
                $user_array['account_name'] = titlecase($account_name);
                $user_array['last_deposit_date'] = formatExcelDate($account->last_deposit_date);
                $user_array['ledger_balance'] = formatExcelFloat($account->ledger_balance);
                $user_array['last_deposit_amount'] = formatExcelFloat($account->last_deposit_amount);
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
        $excel_name = "deposit_accounts_summary";
        $excel_title = "Deposit Accounts Summary";
        $excel_desc = "Deposit Accounts Summary";

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
                    ['ID', 'Acct No','Acct Name','Last Dep Date', 'Ledger Bal', 'Last Dep Amount', 'Company/ Sacco', 'Created At'];

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
