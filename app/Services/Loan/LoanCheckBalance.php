<?php

namespace App\Services\Loan;

use App\Entities\Loan;
use App\Entities\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoanCheckBalance
{

	public function getData($request)
	{

        //create data object
        $data = new Loan();

        $status_open = config('constants.status.open');

        //get params
        $account_no = $request->account_no;
        $phone = $request->phone;
        $the_account_no = "";
        $company_id = $request->company_id;

        if ($account_no) {
            $the_account_no = $account_no;
        }

        if ($phone) {
            $the_account_no = getDatabasePhoneNumber($phone);
        }

        $account_data = DB::table('accounts')
            ->select('account_name')
            ->where('company_id', '=', $company_id)
            ->where(function($q) use ($the_account_no){
                $q->where('account_no', '=', $the_account_no);
                $q->orWhere('phone', '=', $the_account_no);
            }) 
            ->first();

        //get account balance
        $loan_balance_data = DB::table('loan_accounts')
            ->join('accounts', 'accounts.id', '=', 'loan_accounts.ref_account_id')
            ->select('loan_accounts.loan_bal')
            ->where('loan_accounts.company_id', '=', $company_id)
            ->where('loan_accounts.status_id', '=', $status_open)
            ->where(function($q) use ($the_account_no){
                $q->where('accounts.account_no', '=', $the_account_no);
                $q->orWhere('accounts.phone', '=', $the_account_no);
            })            
            ->first();

        if (!$loan_balance_data) {
            //$response["message"] = "You have no active loan";
            $loan_bal = 0;
        } else {
            $loan_bal = $loan_balance_data->loan_bal;
        }

        $account_name = titlecase($account_data->account_name);
        $ledger_balance = formatCurrency($loan_bal);

        $response["account_name"] = $account_name;
        $response["ledger_balance"] = $ledger_balance;

		//start send sms to user
        //$sms_type_id = config('constants.sms_types.company_sms');
        //get company_details
        $company = Company::find($company_id);
        $short_name = $company->name; 
        
        $message = "$short_name, \n\n";
        $message .= " Account Name: $account_name,\n Loan Balance: $ledger_balance";

        //$result = createSmsOutbox($message, $phone, $sms_type_id, $company_id);
        //end send sms to user

        return show_json_success($response);

	}

}