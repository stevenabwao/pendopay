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
use App\User;
use Carbon\Carbon;  
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentDepositStoreNew
{

    use Helpers;

    public function createItem($payment_id, $attributes) {

        //dd($payment_id, $attributes);

        //DB::enableQueryLog();

        //current date and time
        $date = Carbon::now();
        //$date = getLocalDate($date);
        $date = $date->toDateTimeString();

        $savings_product_id = config('constants.account_settings.savings_account_product_id');
        $deposit_product_id = config('constants.account_settings.deposit_account_product_id');
        $status_active = config('constants.status.active');
        $status_disabled = config('constants.status.disabled');
        $registration_sms_type_id = config('constants.sms_types.registration_sms');
        $registration_gl_account_type_id = config('constants.gl_account_types.registration');
        $client_deposits_gl_account_type_id = config('constants.gl_account_types.client_deposits');

        DB::beginTransaction();

            //get sent details
            $paybill_number = "";
            $company_id = "";
            $account_no = "";
            $amount = "";
            $mpesa_code = "";
            //$payment_id = "";
            $payment_name = "";

            if (array_key_exists('account_no', $attributes)) {
                $account_no = $attributes['account_no'];
            }
            if (array_key_exists('phone', $attributes)) {
                $phone = $attributes['phone'];
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
            if (array_key_exists('src_ip', $attributes)) {
                $src_ip = $attributes['src_ip'];
            }
            if (array_key_exists('trans_id', $attributes)) {
                $trans_id = $attributes['trans_id'];
            }
            if (array_key_exists('company_id', $attributes)) {
                $company_id = $attributes['company_id'];
            }
            if (array_key_exists('trans_id', $attributes)) {
                $mpesa_code = $attributes['trans_id'];
            }
            // if (array_key_exists('payment_id', $attributes)) {
            //     $payment_id = $attributes['payment_id'];
            // }
            if (array_key_exists('full_name', $attributes)) {
                $payment_name = $attributes['full_name'];
            }
            if (array_key_exists('modified', $attributes)) {
                $modified = $attributes['modified'];
            }

            //get company_id
            if (!$company_id && $paybill_number) {
                //get company_id from paybill_number
                //start get main paybill no
                $mpesa_paybill_data = getMainSingleCompanyPaybillData($paybill_number);
                $mpesa_paybill_data = json_decode($mpesa_paybill_data);
                $mpesa_paybill_data = $mpesa_paybill_data->data;

                $company_id = $mpesa_paybill_data->company_id;

                //dd($paybill_number, $company_id, $mpesa_paybill_data);
            }

            //get payment account data
            $account_data = Account::where('account_no', $account_no)
                                    ->where('company_id', $company_id)
                                    ->first();


                                    /*$account_data = Account::where('company_id', $company_id)
                                    ->where(function($q) use ($account_no){
                                        $q->where('account_no', '=', $account_no);
                                        $q->orWhere('phone', '=', $account_no);
                                    })
                                    ->first();
                                    */

            if (!$account_data) {
                //convert phone number to a fully qualified phone number
                try {
                    $account_no = getDatabasePhoneNumber($account_no);
                    $account_data = Account::where('phone', $account_no)
                                        ->where('company_id', $company_id)
                                        ->first();
                } catch(\Exception $e) {
                    dd($e);
                    $message = $e->getMessage() . ". Invalid account number.";
                    //dd($e);
                    log_this($message);
                    throw new StoreResourceFailedException($message);
                }

            }

            //dd($account_data);

            //print_r(DB::getQueryLog());
            //if no account record exists, throw an error
            if (!$account_data) {
                //throw an error, account record does not exist
                //throw new StoreResourceFailedException('Non existent account!!! Please check the account_no');
                //$contact_phone = "0720743211";
                $message = "Wrong account number entered!!!";
                dd($message);
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
                $message = "Deposit account does not exist!!!";
                dd($message);
                log_this($message);
                throw new StoreResourceFailedException($message);
            }
            $deposit_account_no = $deposit_account_data->account_no;
            //dd($deposit_account_no);

            //user data
            $user_data = User::find($user_id);
            if (!$user_data) {
                $message = "User data does not exist!!!";
                dd($message);
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

            //dd($company_name, $company_short_name, $company_id);

            //end check if account_no exists

            if ($account_data) {

                //check whether company requires registration fees
                //registration event == 1
                $event_type_id = 1;
                $registration_amount = getCompanyEventCost($company_id, $event_type_id);
                //dd($registration_amount);

                //set account no and other attributes
                $attributes['account_no'] = $deposit_account_no;
                $attributes['company_user_id'] = $company_user_id;
                $attributes['user_id'] = $user_id;

                //get company user data
                $company_user_data = CompanyUser::find($company_user_id);
                $registration_paid = $company_user_data->registration_paid;
                $registration_amount_paid = $company_user_data->registration_amount_paid;

                if ($registration_amount > 0) {

                    //dd($company_user_data);

                    //if user has paid for registration, skip this by creating new deposit of amount paid
                    if ($registration_paid) {

                        try {

                            //dd($attributes);
                            //create a new deposit
                            $deposit_store = new DepositStore();

                            $new_deposit = $deposit_store->createItem($attributes);

                            $bal_amount = $amount;

                        } catch(\Exception $e) {

                            dd($e);
                            DB::rollback();
                            //dd($e);
                            $message = 'Error. Could not save new deposit details - ' . $e->getMessage();
                            log_this($message);
                            throw new StoreResourceFailedException($message);
                            //return show_error($message);

                        }

                    } else {

                        //user has not paid registration fees
                        //any extras??
                        //get remaining reg balance, if any
                        $registration_balance = $registration_amount - $registration_amount_paid;
                        $extra_payment = $amount - $registration_balance;

                        $reg_paid = 0;

                        //has user paid all reg amount?
                        if ($extra_payment > 0) {

                            //user has paid all reg amount

                            //create new deposit
                            try {

                                //store the extra payment as part of account deposits, deduct reg amount
                                $attributes['amount'] = $extra_payment;
                                //dd($attributes);

                                $deposit_store = new DepositStore();

                                $new_deposit = $deposit_store->createItem($attributes);

                                //set registration amount paid
                                $reg_amount = $registration_balance;
                                $reg_paid = 1;
                                $bal_amount = $extra_payment;

                            } catch(\Exception $e) {

                                dd($e);
                                DB::rollback();
                                //throw new StoreResourceFailedException($e);
                                //dd($e);
                                $message = 'Error. Could not save new deposit details - ' . $e->getMessage();
                                log_this($message);
                                throw new StoreResourceFailedException($message);
                                //return show_error($message);

                            }

                        } else if ($amount == $registration_balance) {

                            //user has paid all reg amount
                            try {

                                //update company user
                                $company_user_update = CompanyUser::where('id', $company_user_id)
                                    ->update([
                                                'registration_amount_paid' => $amount,
                                                'registration_paid' => 1,
                                                'registration_paid_date' => $date
                                            ]);

                                //set registration amount paid
                                $reg_amount = $amount;
                                $reg_paid = 1;
                                $bal_amount = 0;

                            } catch(\Exception $e) {

                                dd($e);
                                DB::rollback();
                                //dd($e);
                                $message = 'Error. Could not update company user - ' . $e->getMessage();
                                log_this($message);
                                throw new StoreResourceFailedException($message);

                                //return show_error($message);

                            }


                        } else if ($amount < $registration_balance) {

                            //get total reg amount paid by user

                            try {

                                $total_registration_amount_paid = $registration_amount_paid + $amount;
                                //update company user
                                $company_user_update = CompanyUser::where('id', $company_user_id)
                                    ->update([
                                                'registration_amount_paid' => $total_registration_amount_paid
                                            ]);

                                //set registration amount paid
                                $reg_amount = $amount;
                                $reg_balance = $registration_balance - $amount;
                                $reg_balance = formatCurrency($reg_balance);
                                $bal_amount = 0;

                                //registration not complete, send message
                                $message = "Dear $first_name, thank you for your payment to $company_name. ";
                                $message .= "Please complete registration balance of : $reg_balance to activate your account. ";
                                $message .= "Regards, $company_short_name Team.";

                                //send sms
                                $result = createSmsOutbox($message, $phone, $registration_sms_type_id, $company_id, $company_user_id);

                            } catch(\Exception $e) {

                                dd($e);
                                DB::rollback();
                                //dd($e);
                                $message = 'Error. Could not update company user - ' . $e->getMessage();
                                log_this($message);
                                throw new StoreResourceFailedException($message);
                                //return show_error($message);

                            }

                        }


                        //CREATE GL ACCOUNT ENTRIES
                        try {

                            //start create reg gl account entry
                            $tran_ref_txt = "$mpesa_code - payment_name $payment_name - payment_id $payment_id";
                            //dd($tran_ref_txt, $payment_name, $payment_id);
                            $tran_desc = "Registration - company user id - $company_user_id";
                            $reg_gl_account_entry = createGlAccountEntry($payment_id, $reg_amount, $registration_gl_account_type_id, 
                                                                         $company_id, $phone, "DR", $tran_ref_txt, $tran_desc, "neg");
                            //dd($reg_gl_account_entry);
                            //end create reg gl account entry

                        } catch(\Exception $e) {

                            dd($e);
                            DB::rollback();
                            //dd($e);
                            $message = 'Error. Could not create reg_gl_account_entry - ' . $e->getMessage();
                            log_this($message);
                            throw new StoreResourceFailedException($message);

                        }


                        if ($reg_paid) {

                            //enable company user
                            try {

                                $company_user_update = CompanyUser::where('id', $company_user_id)
                                    ->update([
                                                'registration_amount_paid' => $registration_amount,
                                                'registration_paid' => 1,
                                                'registration_paid_date' => $date
                                            ]);

                            } catch(\Exception $e) {

                                dd($e);
                                DB::rollback();
                                //dd($e);
                                $message = 'Error. Could not update company user - ' . $e->getMessage();
                                log_this($message);
                                throw new StoreResourceFailedException($message);
                                //return show_error($message);

                            }

                            //start enable savings and deposit accounts
                            try {

                                $savings_account_number = enableUserAccount($company_id, $company_user_id, $savings_product_id);

                            } catch(\Exception $e) {

                                dd($e);
                                DB::rollback();
                                //dd($e);
                                $message = 'Error. Could not enable savings account - ' . $e->getMessage();
                                log_this($message);
                                throw new StoreResourceFailedException($message);

                            }


                            try {

                                $deposit_account_number = enableUserAccount($company_id, $company_user_id, $deposit_product_id);

                            } catch(\Exception $e) {

                                dd($e);
                                DB::rollback();
                                $message = 'Error. Could not enable deposit account - ' . $e->getMessage();
                                log_this($message);
                                throw new StoreResourceFailedException($message);

                            }
                            //end enable savings and deposit accounts

                            //start get main paybill no
                            $mpesa_paybill = getMainCompanyPaybill($company_id);
                            //dd($mpesa_paybill);
                            //end get main paybill no

                            //get savings account number
                            $savings_account_data = Account::where('company_user_id', $company_user_id)
                                    ->where('company_id', $company_id)
                                    ->where('product_id', $savings_product_id)
                                    ->first();

                            $savings_account_number = $savings_account_data->account_no;
                            $phone = getLocalisedPhoneNumber($savings_account_data->phone);

                            //send activation sms - check $reg_paid = 1;
                            $message = "Dear $first_name, thank you for joining $company_name. ";
                            $message .= "Your account is now active. Make deposits to your account via Mpesa ";
                            $message .= "paybill no. $mpesa_paybill,  Acct no: $phone. ";
                            $message .= "Dial *533# and select $company_short_name to view your account. ";
                            $message .= "Thank you.";

                            //dd($message);

                            //send sms
                            $result = createSmsOutbox($message, $phone, $registration_sms_type_id, $company_id, $company_user_id);

                        }

                    }

                } else {

                    //no registration fees required
                    $bal_amount = $amount; 

                    try {

                        //create a new deposit
                        $deposit_store = new DepositStore();

                        $new_deposit = $deposit_store->createItem($attributes);

                    } catch(\Exception $e) {

                        dd($e);
                        DB::rollback();
                        $message = 'Error. Could not create deposit entries - ' . $e->getMessage();
                        log_this($message);
                        throw new StoreResourceFailedException($message);
                        //$message = 'Error. Could not save new deposit details';
                        //return show_error($message);

                    }

                }


                //save payment to client dep gl accounts
                if ($bal_amount > 0) {

                    try {

                        $tran_ref_txt = "$mpesa_code - $payment_name - $payment_id";
                        $tran_desc = "Deposit - company user - $company_user_id";
                        $client_dep_gl_account_entry = createGlAccountEntry($payment_id, $bal_amount, $client_deposits_gl_account_type_id, 
                                                                            $company_id, $phone, "DR", $tran_ref_txt, $tran_desc, "neg");

                    } catch(\Exception $e) {

                        dd($e);
                        DB::rollback();
                        
                        $message = 'Error. Could not create client_dep_gl_account_entry - ' . $e->getMessage();
                        log_this($message);
                        throw new StoreResourceFailedException($message);

                    }

                }

            }


        DB::commit();

        $response['account'] = $account_data;
        $response['deposit_account'] = $deposit_account_data;
        $response['user'] = $user_data;
        $response['company_user'] = $company_user_data;
        $response['company'] = $company_user_data->company;

        //dd($response);

        return json_encode($response); 

    }

}
