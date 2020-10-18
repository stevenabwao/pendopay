<?php

namespace App\Services\User;

use App\Entities\Account;
use App\Entities\DepositAccount;
use App\Entities\CompanyUser;
use App\User;
use App\Events\UserConfirmed;
use App\Services\User\CreateUserAccount;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; 

class CreateUserAccount
{

    use Helpers;

    public function createAccount($company_user) {

        //current date and time 
        $date = Carbon::now();
        $date = getLocalDate($date);
        $date = $date->toDateTimeString();

        //global variables
        $loan_repayment_product_id = config('constants.account_settings.loan_account_product_id');
        $savings_product_id = config('constants.account_settings.savings_account_product_id');
        $deposit_product_id = config('constants.account_settings.deposit_account_product_id');
        $status_active = config('constants.status.active');
        $status_disabled = config('constants.status.disabled');

        DB::beginTransaction();

            //start create new company_user savings account
            try {

                $user_savings_account = new Account();

                $user = $company_user->user;
                $company = $company_user->company;

                //get next account number
                $company_id = $company->id;
                $user_id = $company_user->id;
                $savings_account_no = generate_account_number($company_id, '', $user_id,  $savings_product_id);

                $acct_attributes['account_no'] = $savings_account_no;
                $acct_attributes['phone'] = $user->phone;
                $acct_attributes['account_name'] = $user->first_name . ' ' . $user->last_name;
                $acct_attributes['product_id'] = $savings_product_id;
                $acct_attributes['company_id'] = $company->id;
                $acct_attributes['user_id'] = $company_user->user_id;
                $acct_attributes['company_user_id'] = $company_user->id;

                $user_savings_account = $user_savings_account::create($acct_attributes);

            } catch(Exception $e) {

                DB::rollback();
                
                $message = "Could not create user savings account";
                throw new StoreResourceFailedException($message);
                //return show_error($message);

            }
            //end create new user savings account


            //start create new user loan repayment account
            /*
            try {

                $user_loan_repayment_account = new Account();

                //get next account number
                $company_id = $company->id;
                $user_cd = $user->user_cd;
                $account_number = generate_account_number($company_id, $user_cd, '', $loan_repayment_product_id);

                $user_phone = getDatabasePhoneNumber($user->phone, $user->phone_country);

                $loan_repay_acct_attributes['account_no'] = $account_number;
                $loan_repay_acct_attributes['phone'] = $user_phone;
                $loan_repay_acct_attributes['account_name'] = $user->first_name . ' ' . $user->last_name;
                $loan_repay_acct_attributes['product_id'] = $loan_repayment_product_id;
                $loan_repay_acct_attributes['company_id'] = $company->id;
                $loan_repay_acct_attributes['user_id'] = $company_user->user_id;
                $loan_repay_acct_attributes['company_user_id'] = $user->id;

                $user_loan_repayment_account = $user_loan_repayment_account::create($loan_repay_acct_attributes);

            } catch(Exception $e) {

                DB::rollback();
                throw new StoreResourceFailedException($e);

            }
            */
            //end create new user loan repayment account


            //start create new savings deposit account
            try {

                $deposit_account = new DepositAccount();

                //generate deposit account number
                $company_id = $company->id;
                $user_id = $company_user->id;
                $deposit_account_no = generate_account_number($company_id, '', $user_id,  $deposit_product_id);

                //get account details
                $user_id = $user->id;
                $company_id = $company->id;
                $savings_account_no = $user_savings_account->account_no;
                $savings_account_id = $user_savings_account->id;
                $account_name = $user_savings_account->account_name;

                $dep_acct_attributes['ref_account_id'] = $savings_account_id;
                $dep_acct_attributes['account_no'] = $deposit_account_no;
                $dep_acct_attributes['phone'] = $user->phone;
                $dep_acct_attributes['ref_account_no'] = $savings_account_no;
                $dep_acct_attributes['account_name'] = $account_name;
                $dep_acct_attributes['product_id'] = $savings_product_id;
                $dep_acct_attributes['opened_at'] = $date;
                $dep_acct_attributes['available_at'] = $date;
                $dep_acct_attributes['company_id'] = $company_id;
                $dep_acct_attributes['user_id'] = $company_user->user_id;
                $dep_acct_attributes['company_user_id'] = $company_user->id;
                $dep_acct_attributes['primary_user_id'] = $company_user->user_id;

                $deposit_account = $deposit_account::create($dep_acct_attributes);

            } catch(Exception $e) {

                DB::rollback();
                $message = "Could not create user deposit account";
                throw new StoreResourceFailedException($message);

            }
            //end create new savings deposit account


            //start create new loan repayment deposit account
            /*try {

                $deposit_account = new DepositAccount();

                //get account details
                $user_id = $user->id;
                $company_id = $user->company_id;
                $account_no = $user_loan_repayment_account->account_no;
                $account_id = $user_loan_repayment_account->id;
                $account_name = $user_loan_repayment_account->account_name;

                $dep_loan_repayment_acct_attributes['account_id'] = $account_id;
                $dep_loan_repayment_acct_attributes['account_no'] = $account_no;
                $dep_loan_repayment_acct_attributes['account_name'] = $account_name;
                $dep_loan_repayment_acct_attributes['product_id'] = $loan_repayment_product_id;
                $dep_loan_repayment_acct_attributes['opened_at'] = $date;
                $dep_loan_repayment_acct_attributes['available_at'] = $date;
                $dep_loan_repayment_acct_attributes['company_id'] = $company_id;
                $dep_loan_repayment_acct_attributes['primary_user_id'] = $user_id;

                $deposit_account = $deposit_account::create($dep_loan_repayment_acct_attributes);

            } catch(Exception $e) {

                DB::rollback();
                throw new StoreResourceFailedException($e);

            }*/
            //end create new loan repayment deposit account

            //send sms and email to user with  details on created account
            //dispatch a new event
            //convert object to array, then to User model
            //$company_user_array = json_decode(json_encode($company_user), True);
            //$company_user = new CompanyUser($company_user_array);
            //fire event
            //event(new UserConfirmed($company_user));


        DB::commit();

        //formulate return message
        $accounts['user_savings_account'] = $user_savings_account;
        $accounts['deposit_account'] = $deposit_account;

        $result['message'] = "User account successfully created";
        $result['accounts'] = $accounts;
        $result['status_code'] = '200';

        return json_decode(json_encode($result));

    }

}
