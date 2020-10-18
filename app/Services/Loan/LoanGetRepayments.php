<?php

namespace App\Services\Loan;

use App\Entities\Loan;
use App\Entities\CompanyProduct;
use App\Entities\LoanProductSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoanGetRepayments
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
        $loan_amt = "";

        if (array_key_exists('account_no', $attributes)) {
            $account_no = $attributes['account_no'];
        }
        if (array_key_exists('company_id', $attributes)) {
            $company_id = $attributes['company_id'];
        }
        if (array_key_exists('phone', $attributes)) {
            $phone = $attributes['phone'];
        }
        if (array_key_exists('loan_amt', $attributes)) {
            $loan_amt = $attributes['loan_amt'];
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

            //get the company loan product settings
            $loan_product_setting = LoanProductSetting::where('company_product_id', $company_product_id)
                                    ->first();

            //start get loan product settings
            $interest_type = $loan_product_setting->interest_type;
            $interest_amount = $loan_product_setting->interest_amount;
            //end get loan product settings

            //get interest amt
            if ($interest_type == 'percentage') {
                $total_interest = $loan_amt * ($interest_amount / 100);
            } else {
                $total_interest = $interest_amount;
            }

            //get total loan plus interest
            $total_loan_plus_interest = $loan_amt + $total_interest; 

            //get user loan repayments
            $loan_repayment_data = getLoanRepaymentData($company_product_id, $total_loan_plus_interest);
            $loan_repayment_data = json_decode($loan_repayment_data);

            $response["account_name"] = titlecase($account_data->account_name);
            $response["repayment_data"] = $loan_repayment_data->message;

            //dd($response);

            return show_json_success($response);

        } else {

            $message = "Non existent account! Please try again.";
            return show_json_error($message);

        }

	}

}