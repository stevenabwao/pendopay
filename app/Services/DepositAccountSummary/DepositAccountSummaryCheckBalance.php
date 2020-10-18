<?php

namespace App\Services\DepositAccountSummary;

use App\Entities\DepositAccountSummary;
use App\Entities\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DepositAccountSummaryCheckBalance
{

	public function getData($attributes)
	{

        //DB::enableQueryLog();

        //create data object
        $data = new DepositAccountSummary(); 

        //get params
        $account_no = "";
        $phone = "";
        $company_id = "";
        $the_account_no = "";

        if (array_key_exists('account_no', $attributes)) {
            $the_account_no = $attributes['account_no'];
        }
        if (array_key_exists('company_id', $attributes)) {
            $company_id = $attributes['company_id'];
        }
        if (array_key_exists('phone', $attributes)) {
            $phone = $attributes['phone'];
        }
     
        if ($phone) {
            try{
                $phone = getDatabasePhoneNumber($phone);
            } catch (\Exception $e) {
                $message = "Please enter correct phone number as the account no!";
                return show_json_error($message); 
            }
        }

        //get authorised user
        $user = auth()->user();

        //start store user account inquiry history
        $section_name = "SavingsBalanceInquiry";
        saveUserAccountInquiry($user, $section_name, $phone, $company_id);
        //end store user account inquiry history

        $account_data = DB::table('accounts')
            ->select('account_name')
            ->where('company_id', $company_id)
            ->where(function($q) use ($the_account_no, $phone){
                $q->where('account_no', $the_account_no);
                $q->orWhere('phone', $phone);
            })
            ->first();

        //print_r(DB::getQueryLog());

        //dd($account_data);

        //get account balance
        $ledger_balance_data = DB::table('accounts')
            ->join('deposit_accounts', 'accounts.id', '=', 'deposit_accounts.ref_account_id')
            ->join('deposit_account_summary', 'deposit_accounts.account_no', '=', 'deposit_account_summary.account_no')
            ->select('deposit_account_summary.ledger_balance')
            ->where('deposit_account_summary.company_id', $company_id)
            ->where(function($q) use ($the_account_no, $phone){
                $q->where('accounts.account_no', $the_account_no);
                $q->orWhere('accounts.phone', $phone);
            })
            ->first();

        if (!$ledger_balance_data) {
            $ledger_balance = 0;
        } else {
            $ledger_balance = $ledger_balance_data->ledger_balance;
        }

        $account_name = titlecase($account_data->account_name);

        $ledger_balance_fmt = formatCurrency($ledger_balance);

        $response["account_name"] = $account_name;
        $response["ledger_balance"] = $ledger_balance_fmt;

        //dd($response);

        //start send sms to user
        $sms_type_id = config('constants.sms_types.company_sms');
        //get company_details
        $company = Company::find($company_id);
        $short_name = $company->name; 
        
        $message = "$short_name, \n\n";
        $message .= " Account Name: $account_name,\n Savings Balance: $ledger_balance_fmt";

        $result = createSmsOutbox($message, $phone, $sms_type_id, $company_id);
        //end send sms to user

        return show_json_success($response);

	}

}