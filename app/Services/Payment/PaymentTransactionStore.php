<?php

namespace App\Services\Payment;

use App\Entities\Account;
use App\Entities\CompanyUser;
use App\Entities\DepositAccount;
use App\Services\Deposit\DepositStore;
use App\Entities\RegistrationPayment;
use App\Services\Transaction\TransactionStore;
use App\User;
use Illuminate\Support\Facades\DB;

class PaymentTransactionStore
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
            if (array_key_exists('source_account_no', $attributes)) {
                $source_account_no = $attributes['source_account_no'];
            }
            if (array_key_exists('destination_account_no', $attributes)) {
                $destination_account_no = $attributes['destination_account_no'];
            }

            // get barddy company id
            $site_settings = getSiteSettings();
            $settings_company_id = $site_settings['company_id'];

            $transaction_account_data = NULL;

            // dd("INN destination_account_no === ", $attributes, $destination_account_no);

            // start get transaction account
            try {

                $transaction_account_data = getTransactionAccountData($destination_account_no);
                $deposit_account_no = $transaction_account_data->account_no;
                $deposit_user_id = $transaction_account_data->user_id;

            } catch(\Exception $e) {

                $error_message = $e->getMessage();
                log_this($error_message);
                throw new \Exception($error_message);

            }
            // end get transaction account

            if ($transaction_account_data) {

                if ($amount > 0) {

                    try {

                        //create a new transaction
                        $transaction_store = new TransactionStore();

                        if ($transfer != "1") {
                            $tran_ref_txt = "mpesa_code - $mpesa_code - payment_name - $full_name - payment_id - $payment_id";
                            $tran_desc = "Deposit -  user id - $deposit_user_id - Deposit account number - $deposit_account_no";

                            $attributes['tran_ref_txt'] = $tran_ref_txt;
                            $attributes['tran_desc'] = $tran_desc;
                        }
                        $attributes['account_no'] = $deposit_account_no;
                        $attributes['amount'] = $amount;
                        // dd($attributes);
                        $new_transaction = $transaction_store->createItem($attributes);
                        log_this(json_encode($new_transaction));

                    } catch(\Exception $e) {

                        DB::rollback();
                        // dd($e);
                        $show_message = trans('general.couldnotcreatenewtransactiontransfer');
                        log_this($show_message);
                        throw new \Exception($show_message);

                    }

                    //CREATE GL ACCOUNT ENTRIES
                    try {

                        if ($transfer != "1") {
                            $tran_ref_txt = "mpesa_code - $mpesa_code - payment_name - $payment_name - payment_id - $payment_id";
                            $tran_desc = "Deposit - user id - $deposit_user_id - Deposit account number - $deposit_account_no";
                        }
                        $transaction_dep_gl_account_entry = createGlAccountEntry($payment_id, $amount, getGlAccountTypeTransactionDeposits(),
                                                                            $settings_company_id, $phone, "DR", $tran_ref_txt, $tran_desc, "neg", "neg");

                        // dd($transaction_dep_gl_account_entry);
                        log_this("Inserted transaction_dep_gl_account_entry \n" . json_encode($transaction_dep_gl_account_entry));

                    } catch(\Exception $e) {

                        DB::rollback();
                        // dd($e);
                        $show_message = trans('general.couldnotcreatetransactiondepositglentry');
                        log_this($show_message);
                        throw new \Exception($show_message);

                    }

                }

            }

        DB::commit();

        $response['transaction_account'] = $transaction_account_data;
        // $response['user'] = $transaction_account_data->user;

        return json_encode($response);

    }

}
