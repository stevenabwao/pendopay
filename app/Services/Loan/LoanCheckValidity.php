<?php

namespace App\Services\Loan;

use App\Entities\Loan;
use App\Entities\CompanyProduct;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoanCheckValidity
{

	public function getData($attributes)
	{

        $mobile_loan_product_id = config('constants.account_settings.mobile_loan_product_id');

        DB::enableQueryLog();
        //dd($attributes);
        //get params
        $account_no = "";
        $phone = "";
        $company_id = "";
        $the_account_no = "";

        if (array_key_exists('account_no', $attributes)) {
            $account_no = $attributes['account_no'];
        }
        if (array_key_exists('company_id', $attributes)) {
            $company_id = $attributes['company_id'];
        }
        if (array_key_exists('phone', $attributes)) {
            $phone = $attributes['phone'];
        }
        if ($account_no) {
            $the_account_no = $account_no; 
        }

        if ($phone){
            try{
                $phone = getDatabasePhoneNumber($phone);
            } catch (\Exception $e) {
                $message = "Please enter correct phone number as the account no!";
                return show_json_error($message);
            }
        }

        //get company_product_id
        $company_product_data = CompanyProduct::where('product_id', $mobile_loan_product_id)
                                ->where('company_id', $company_id)
                                ->first();

        //get company user data
        $account_data = DB::table('users')
            ->join('accounts', 'users.id', '=', 'accounts.user_id')
            ->join('company_user', 'users.id', '=', 'company_user.user_id')
            ->select('company_user.id', 'accounts.account_name')
            ->where('company_user.company_id', $company_id)
            ->where('accounts.company_id', $company_id)
            ->where('accounts.phone', $phone)
            ->first();

            //print_r(DB::getQueryLog());

            //dd('here');

        if ($account_data) {

            //get account limit
            $company_user_id = $account_data->id;
            $company_product_id = $company_product_data->id;

            //get user loan limit
            $loan_limit_message = calculateUserLoanLimit($company_id, $company_product_id, $company_user_id);
            $loan_limit_message = json_decode($loan_limit_message);

            $error = $loan_limit_message->error;
            $message = $loan_limit_message->message;

            //dd($loan_limit_message);

            if (!$error) {
                //
            } else {
                //
            }

            $response["account_name"] = titlecase($account_data->account_name);
            $response["loan_limit"] = $loan_limit_message->message;

            //dd($response);

            return show_json_success($response);

        } else {

            $message = "Non existent account! Please try again.";
            return show_json_error($message);

        }

	}

}