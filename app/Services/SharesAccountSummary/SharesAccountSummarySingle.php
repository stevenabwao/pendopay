<?php

namespace App\Services\SharesAccountSummary;

use App\Entities\SharesAccountSummary;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SharesAccountSummarySingle
{

	public function getData($request)
	{

        DB::enableQueryLog(); 

        //create data object
        $data = new SharesAccountSummary();

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
                    ->where('shares_account_summary.id', $id)
                    ->where('shares_account_summary.company_id', $company_id);
        }
        if ($account_no) {
            $data = $data
                    ->join('accounts', 'accounts.user_id','=','shares_account_summary.user_id')
                    ->where('accounts.account_no', $account_no)
                    ->where('shares_account_summary.company_id', $company_id);
        }
        if ($phone) {
            $data = $data
                    ->join('accounts', 'accounts.user_id','=','shares_account_summary.user_id')
                    ->where('accounts.phone', $phone)
                    ->where('shares_account_summary.company_id', $company_id);
        }
        if ($company_user_id) {
            $data = $data
                    ->where('shares_account_summary.company_user_id', $company_user_id)
                    ->where('shares_account_summary.company_id', $company_id);
        }

        $data = $data->first();

        //print_r(DB::getQueryLog());

		return $data;

	}

}