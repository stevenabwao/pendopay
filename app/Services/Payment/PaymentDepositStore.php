<?php

namespace App\Services\Payment;

use App\Entities\Account;
use App\Entities\CompanyUser;
use App\Entities\DepositAccount;
use App\Services\Deposit\DepositStore;
use App\Entities\RegistrationPayment;
use App\User;
use Illuminate\Support\Facades\DB;

class PaymentDepositStore
{

    public function createItem($payment_id, $attributes) {

        //DB::enableQueryLog();
        // dd($attributes);

        //current date and time
        $date = getCurrentDate(1);

        $client_deposits_gl_account_type_id = config('constants.gl_account_types.client_deposits');

        DB::beginTransaction();

            //get sent details
            $paybill_number = "";
            $company_id = "";
            $account_no = "";
            $amount = "";
            $mpesa_code = "";
            $payment_id = "";
            $payment_name = "";
            $tran_ref_txt = "";
            $tran_desc = "";
            $transfer = "";
            $deposit_account_no = NULL;
            $phone_number = "";

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
            if (array_key_exists('mpesa_code', $attributes)) {
                $mpesa_code = $attributes['mpesa_code'];
            }
            if (array_key_exists('payment_id', $attributes)) {
                $payment_id = $attributes['payment_id'];
            }
            if (array_key_exists('full_name', $attributes)) {
                $payment_name = $attributes['full_name'];
            }
            if (array_key_exists('modified', $attributes)) {
                $modified = $attributes['modified'];
            }
            if (array_key_exists('tran_ref_txt', $attributes)) {
                $tran_ref_txt = $attributes['tran_ref_txt'];
            }
            if (array_key_exists('tran_desc', $attributes)) {
                $tran_desc = $attributes['tran_desc'];
            }
            if (array_key_exists('transfer', $attributes)) {
                $transfer = $attributes['transfer'];
            }

            // get barddy company id
            $site_settings = getSiteSettings();
            $settings_company_id = $site_settings['company_id'];

            $user_deposit_account_data = NULL;

            // get user data
            try {

                $user_data = getUserData($account_no);
                // dd("user_data == ", $user_data);
                $user_id = $user_data->id;

            } catch(\Exception $e) {

                throw new \Exception($e->getMessage());

            }

            // get user deposit account
            try {

                $user_deposit_account_data = getUserDepositAccountData("", "", $user_id);
                $deposit_account_no = $user_deposit_account_data->account_no;
                $deposit_user_id = $user_deposit_account_data->user_id;
                // dd("user_deposit_account_data == ", $user_deposit_account_data);

            } catch(\Exception $e) {

                throw new \Exception($e->getMessage());

            }

            //end check if account_no exists
            if ($user_deposit_account_data) {

                if ($amount > 0) {

                    try {

                        //create a new deposit
                        $deposit_store = new DepositStore();

                        if ($transfer != "1") {
                            $tran_ref_txt = "mpesa_code - $mpesa_code - payment_name - $full_name - payment_id - $payment_id";
                            $tran_desc = "Deposit -  user id - $deposit_user_id - Deposit account number - $deposit_account_no";

                            $attributes['tran_ref_txt'] = $tran_ref_txt;
                            $attributes['tran_desc'] = $tran_desc;
                        }
                        $attributes['account_no'] = $deposit_account_no;
                        $attributes['amount'] = $amount;
                        // dd($attributes);
                        $new_deposit = $deposit_store->createItem($attributes);
                        log_this(json_encode($new_deposit));

                    } catch(\Exception $e) {

                        DB::rollback();
                        // dd($e);
                        $show_message = trans('general.couldnotcreatenewdeposit');
                        log_this($show_message);
                        throw new \Exception($show_message);

                    }

                    //CREATE GL ACCOUNT ENTRIES
                    try {

                        if ($transfer != "1") {
                            $tran_ref_txt = "mpesa_code - $mpesa_code - payment_name - $payment_name - payment_id - $payment_id";
                            $tran_desc = "Deposit - user id - $deposit_user_id - Deposit account number - $deposit_account_no";
                        }
                        $client_dep_gl_account_entry = createGlAccountEntry($payment_id, $amount, $client_deposits_gl_account_type_id,
                                                                            $settings_company_id, $phone, "DR", $tran_ref_txt, $tran_desc, "neg", "neg");

                        // dd($client_dep_gl_account_entry);

                    } catch(\Exception $e) {

                        DB::rollback();
                        dd($e);
                        $show_message = trans('general.couldnotcreateclientdepositglentry');
                        log_this($show_message);
                        throw new \Exception($show_message);

                    }

                }

            }
            //  dd("user_deposit_account_data == ", $user_deposit_account_data);


        DB::commit();

        $response['deposit_account'] = $user_deposit_account_data;
        $response['user'] = $user_deposit_account_data->user;

        return json_encode($response);

    }

}
