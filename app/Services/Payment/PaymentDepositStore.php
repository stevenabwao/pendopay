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
            if (array_key_exists('fully_paid', $attributes)) {
                $fully_paid = $attributes['fully_paid'];
            }
            if (array_key_exists('deposit_amount', $attributes)) {
                $deposit_amount = $attributes['deposit_amount'];
            }

            // get barddy company id
            $site_settings = getSiteSettings();
            $barddy_company_id = $site_settings['barddy_company_id'];

            $account_data = "";

            // get order and company data
            if ($account_no) {
                $statuses_array = array();
                $statuses_array[] = getStatusOrderPlaced();
                $statuses_array[] = getStatusActive();
            }

            // get user account data
            try {

                $account_data = getAccountData('', '', $phone);
                $deposit_account_no = $account_data->account_no;

            } catch(\Exception $e) {

                DB::rollback();
                // dd($e);
                $message = 'Error. Could not get user account';
                log_this($message . ' - ' . $e->getMessage());
                throw new \Exception($message);

            }

            //end check if account_no exists
            if ($account_data) {

                if ($deposit_amount > 0) {

                    try {

                        //create a new deposit
                        $deposit_store = new DepositStore();

                        if ($transfer != "1") {
                            $tran_ref_txt = "mpesa_code - $mpesa_code - payment_name - $full_name - payment_id - $payment_id";
                            $tran_desc = "Deposit -  user id - $account_data->user_id - Deposit account number - $deposit_account_no";

                            $attributes['tran_ref_txt'] = $tran_ref_txt;
                            $attributes['tran_desc'] = $tran_desc;
                        }
                        $attributes['account_no'] = $deposit_account_no;
                        $attributes['amount'] = $deposit_amount;
                        // dd($attributes);
                        $new_deposit = $deposit_store->createItem($attributes);
                        log_this(json_encode($new_deposit));

                    } catch(\Exception $e) {

                        DB::rollback();
                        // dd($e);
                        $message = 'Error. Could not save new deposit details';
                        log_this($message . ' - ' . $e->getMessage());
                        throw new \Exception($message);

                    }

                    //CREATE GL ACCOUNT ENTRIES
                    try {

                        if ($transfer != "1") {
                            $tran_ref_txt = "mpesa_code - $mpesa_code - payment_name - $payment_name - payment_id - $payment_id";
                            $tran_desc = "Deposit - user id - $account_data->user_id - Deposit account number - $deposit_account_no";
                        }
                        $client_dep_gl_account_entry = createGlAccountEntry($payment_id, $deposit_amount, $client_deposits_gl_account_type_id,
                                                                            $barddy_company_id, $phone, "DR", $tran_ref_txt, $tran_desc, "neg", "neg");

                        // dd($client_dep_gl_account_entry);

                    } catch(\Exception $e) {

                        DB::rollback();
                        // dd($e);
                        $message = 'Error. Could not create client_dep_gl_account_entry';
                        log_this($message . ' - ' . $e->getMessage());
                        throw new \Exception($message);

                    }

                }

            }


        DB::commit();

        $response['deposit_account'] = $account_data;
        $response['user'] = $account_data->user;
        $response['company'] = $account_data->company;

        return json_encode($response);

    }

}
