<?php

namespace App\Services\Payment;

use App\Entities\Account;
use App\Entities\Company;
use App\Entities\CompanyUser;
use App\Entities\Payment;
use App\Entities\DepositAccount;
use App\Services\Deposit\DepositStore;
use App\Services\User\CreateUserAccount;
use App\Entities\GlAccountType;
use App\Entities\GlAccountHistory;
use App\Entities\GlAccountSummary;
use App\Entities\RegistrationPayment;
use App\User;
use Carbon\Carbon; 
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentManualDepositStore
{

    use Helpers;

    public function createItem($payment_id, $attributes) {

        //dd("here - ", $payment_id, $attributes);

        //DB::enableQueryLog();

        //current date and time
        $date = Carbon::now();
        $date = $date->toDateTimeString();

        $savings_product_id = config('constants.account_settings.savings_account_product_id');
        $deposit_product_id = config('constants.account_settings.deposit_account_product_id');
        $status_active = config('constants.status.active');
        $status_disabled = config('constants.status.disabled');
        $registration_sms_type_id = config('constants.sms_types.registration_sms');
        $registration_gl_account_type_id = config('constants.gl_account_types.registration');

        $bank_deposits_gl_account_type_id = config('constants.gl_account_types.bank_deposits');
        $mpesa_deposits_gl_account_type_id = config('constants.gl_account_types.mpesa_deposits');
        $cash_deposits_gl_account_type_id = config('constants.gl_account_types.cash_deposits');

        //payment methods
        $mpesa_payment_id = config('constants.payment_methods.mpesa');
        $cash_payment_id = config('constants.payment_methods.cash');
        $bank_payment_id = config('constants.payment_methods.bank');

        //DB::beginTransaction();

        //get sent details
        $paybill_number = "";
        $company_id = "";
        $phone = "";
        $account_no = "";
        $amount = "";
        $mpesa_code = "";
        $cheque_no = "";
        $bank_name = "";
        $payment_id = "";
        $payment_name = "";
        $payment_at = "";
        $tran_ref_txt = "";
        $tran_desc = "";
        $payment_method_id = "";

        if (array_key_exists('phone', $attributes)) {
            $phone = $attributes['phone'];
        }
        if (array_key_exists('account_no', $attributes)) {
            $account_no = $attributes['account_no'];
        }
        if (array_key_exists('amount', $attributes)) {
            $amount = $attributes['amount'];
        }
        if (array_key_exists('paybill_number', $attributes)) {
            $paybill_number = $attributes['paybill_number'];
        }
        if (array_key_exists('full_name', $attributes)) {
            $full_name = $attributes['full_name'];
        }
        if (array_key_exists('company_id', $attributes)) {
            $company_id = $attributes['company_id'];
        }
        if (array_key_exists('mpesa_code', $attributes)) {
            $mpesa_code = $attributes['mpesa_code'];
        }
        if (array_key_exists('cheque_no', $attributes)) {
            $cheque_no = $attributes['cheque_no'];
        }
        if (array_key_exists('bank_name', $attributes)) {
            $bank_name = $attributes['bank_name'];
        }
        if (array_key_exists('payment_id', $attributes)) {
            $payment_id = $attributes['payment_id'];
        }
        if (array_key_exists('payment_name', $attributes)) {
            $payment_name = $attributes['payment_name'];
        }
        if (array_key_exists('payment_at', $attributes)) {
            $payment_at = $attributes['payment_at'];
        }
        if (array_key_exists('tran_ref_txt', $attributes)) {
            $tran_ref_txt = $attributes['tran_ref_txt'];
        }
        if (array_key_exists('tran_desc', $attributes)) {
            $tran_desc = $attributes['tran_desc'];
        }
        if (array_key_exists('payment_method_id', $attributes)) {
            $payment_method_id = $attributes['payment_method_id'];
        }

        //get company_id
        if (!$company_id && $paybill_number) {
            //get company_id from paybill_number
            //start get main paybill no
            $mpesa_paybill_data = getMainSingleCompanyPaybillData($paybill_number);
            $mpesa_paybill_data = json_decode($mpesa_paybill_data);
            $mpesa_paybill_data = $mpesa_paybill_data->data;

            $company_id = $mpesa_paybill_data->company_id;

            //dump($paybill_number, $company_id, $mpesa_paybill_data);
        }

        //get payment account data
        $account_data = "";

        if ($account_no && $company_id) {
            $account_data = Account::where('account_no', $account_no)
                                    ->where('company_id', $company_id)
                                    ->first();
        }

        if (!$account_data) {
            //convert phone number to a fully qualified phone number
            try {
                $phone = getDatabasePhoneNumber($phone);
                $account_data = Account::where('phone', $phone)
                                    ->where('company_id', $company_id)
                                    ->first();
            } catch(\Exception $e) {
                $message = $e->getMessage() . ". Invalid account number.";
                log_this($message);
                throw new StoreResourceFailedException($message);
            }

        }

        //dd(" -- in -- attributes -- ", $attributes, $account_data);

        //print_r(DB::getQueryLog());

        //if no account record exists, throw an error
        if (!$account_data) {
            //throw an error, account record does not exist
            $message = "Invalid account number/ phone number";
            log_this($message);
            throw new StoreResourceFailedException($message);
        }

        $company_id = $account_data->company_id;
        $company_user_id = $account_data->company_user_id;
        $user_id = $account_data->user_id;
        $account_no = $account_data->account_no;

        //find deposit account no
        $deposit_account_data = DepositAccount::where('ref_account_no', $account_no)->first();
        if (!$deposit_account_data) {
            $message = "Deposit account does not exist";
            log_this($message);
            throw new StoreResourceFailedException($message);
        }
        $deposit_account_no = $deposit_account_data->account_no;

        // Get company user data
        $company_user_data = CompanyUser::find($company_user_id);
        if (!$company_user_data) {
            $message = "Company user data does not exist";
            log_this($message);
            throw new StoreResourceFailedException($message);
        }

        //user data
        $user_data = User::find($user_id);
        if (!$user_data) {
            $message = "User data does not exist!!!";
            log_this($message);
            throw new StoreResourceFailedException($message);
        }
        $user_id = $user_data->id;
        $first_name = titlecase($user_data->first_name);
        $last_name = titlecase($user_data->last_name);

        //dd($user_data);

        //company name
        $company_name = $account_data->company->name;
        $company_short_name = $account_data->company->short_name;

        //dd($company_name, $payment_method_id, $company_id);

        // Create GL account entries
        if ($account_data) {


            //dd($account_data, $payment_method_id);

            // Get the GL account type
            $gl_account_type_id = "";

            if ($payment_method_id == $bank_payment_id) { 
                $gl_account_type_id = $bank_deposits_gl_account_type_id; 
                $gl_account_type_name = 'Bank deposits GL account'; 
            }
            
            if ($payment_method_id == $mpesa_payment_id) { 
                $gl_account_type_id = $mpesa_deposits_gl_account_type_id; 
                $gl_account_type_name = 'Mpesa deposits GL account'; 
            }

            if ($payment_method_id == $cash_payment_id) { 
                $gl_account_type_id = $cash_deposits_gl_account_type_id; 
                $gl_account_type_name = 'Cash deposits GL account'; 
            }

            // Store GL entry data
            if ($gl_account_type_id) {

                //dd($gl_account_type_id);

                try {

                    if (!$tran_ref_txt) {
                        $tran_ref_txt = "mpesa_code - $mpesa_code - payment_name - $payment_name - payment_id - $payment_id";
                    }
                    if (!$tran_desc) {
                        $tran_desc = "Manual payment entry - company user - $company_user_id";
                    }
                    
                    createGlAccountEntry($payment_id, $amount, $gl_account_type_id, $company_id, $phone, 
                                            "DR", $tran_ref_txt, $tran_desc, "neg", "neg");

                } catch(\Exception $e) {

                    //DB::rollback();
                    $message = "Error. Could not create $gl_account_type_name - " . $e->getMessage();
                    log_this($message);
                    throw new StoreResourceFailedException($message);

                }

            }

        }

        //DB::commit();

        $response['account'] = $account_data;
        $response['deposit_account'] = $deposit_account_data;
        $response['user'] = $user_data;
        $response['company_user'] = $company_user_data;
        $response['company'] = $account_data->company;

        return json_encode($response);

    }

}