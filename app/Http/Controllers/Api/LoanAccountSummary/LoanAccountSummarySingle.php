<?php

namespace App\Services\LoanAccountSummary;

use App\Entities\LoanAccountSummary;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoanAccountSummarySingle
{

	public function getData($request)
	{

        DB::enableQueryLog(); 

        //create data object
        $data = new DepositAccountSummary();

        //get params
        $id = $request->id;
        $account_no = $request->account_no;
        $phone = $request->phone;
        $company_id = $request->company_id;
        $company_user_id = $request->company_user_id;

        if ($phone) {
            //convert phone and return error in case
            try {
                $phone = getDatabasePhoneNumber($phone);
            } catch(\Exception $e) {
                return null;
            }
        }

        //filter results 
        if ($id) {
            $data = $data
                    ->where('deposit_account_summary.id', $id)
                    ->where('deposit_account_summary.company_id', $company_id);
        }
        if ($account_no) {
            $data = $data
                    ->join('accounts', 'accounts.user_id','=','deposit_account_summary.user_id')
                    ->where('accounts.account_no', $account_no)
                    ->where('deposit_account_summary.company_id', $company_id);
        }
        if ($phone) {
            $data = $data
                    ->join('accounts', 'accounts.user_id','=','deposit_account_summary.user_id')
                    ->where('accounts.phone', $phone)
                    ->where('deposit_account_summary.company_id', $company_id);
        }
        if ($company_user_id) {
            $data = $data
                    ->where('deposit_account_summary.company_user_id', $company_user_id)
                    ->where('deposit_account_summary.company_id', $company_id);
        }

        $data = $data->first();

        //print_r(DB::getQueryLog());

		return $data;

	}

}