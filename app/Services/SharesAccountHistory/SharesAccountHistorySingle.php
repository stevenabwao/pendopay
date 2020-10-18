<?php

namespace App\Services\SharesAccountHistory;

use App\Entities\SharesAccountHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SharesAccountHistorySingle
{

	public function getData($request)
	{

        //DB::enableQueryLog(); 

        //create data object
        $data = new SharesAccountHistory();

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
                    ->where('shares_account_history.id', $id)
                    ->where('shares_account_history.company_id', $company_id);
        }
        if ($account_no) {
            $data = $data
                    ->join('accounts', 'accounts.user_id','=','shares_account_history.user_id')
                    ->where('accounts.account_no', $account_no)
                    ->where('shares_account_history.company_id', $company_id);
        }
        if ($phone) {
            $data = $data
                    ->join('accounts', 'accounts.user_id','=','shares_account_history.user_id')
                    ->where('accounts.phone', $phone)
                    ->where('shares_account_history.company_id', $company_id);
        }
        if ($company_user_id) {
            $data = $data
                    ->where('shares_account_history.company_user_id', $company_user_id)
                    ->where('shares_account_history.company_id', $company_id);
        }

        $data = $data->get();

        //print_r(DB::getQueryLog());
        //dd('here');

		return $data;

	}

}