<?php

namespace App\Services\EmailBatch;

use App\Entities\Loan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EmailBatchIndex
{

	public function getData($request)
	{

        DB::enableQueryLog(); 

        //create data object
        $data = new Loan();

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
                    ->where('deposit_account_history.id', $id)
                    ->where('deposit_account_history.company_id', $company_id);
        }
        if ($account_no) {
            $data = $data
                    ->join('accounts', 'accounts.user_id','=','deposit_account_history.user_id')
                    ->where('accounts.account_no', $account_no)
                    ->where('deposit_account_history.company_id', $company_id);
        }
        if ($phone) {
            $data = $data
                    ->join('accounts', 'accounts.user_id','=','deposit_account_history.user_id')
                    ->where('accounts.phone', $phone)
                    ->where('deposit_account_history.company_id', $company_id);
        }
        if ($company_user_id) {
            $data = $data
                    ->where('deposit_account_history.company_user_id', $company_user_id)
                    ->where('deposit_account_history.company_id', $company_id);
        }

        $data = $data->get();

        //print_r(DB::getQueryLog());
        //dd('here');

		return $data;

	}

}