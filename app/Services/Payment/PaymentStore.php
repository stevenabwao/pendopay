<?php

namespace App\Services\Payment;

use App\Entities\Payment;
use App\Entities\PaymentDeposit;
use App\Services\Payment\PaymentDepositStore;
use Illuminate\Support\Facades\DB;

class PaymentStore
{

    public function createItem($attributes, $new_payment) {

        // dd($attributes, $new_payment);

        $mpesa_payment_id = getPaymentMethodMpesa();

        $payment_made = false;
        $deposit_made = false;

        $repost = false;
        $date = getCurrentDate(1);

        $paybill_number = "";
        $phone_number = "";
        $account_no = "";
        $trans_id = "";
        $tran_desc = "";
        $bank_name = "";
        $cheque_no = "";
        $mpesa_code = "";
        $payment_at = "";
        $payment_method_id = "";
        $transfer = "";
        $payment_id = "";
        $tran_ref_txt = "";
        $destination_account_type = "";

        if (array_key_exists('bank_name', $attributes)) {
            $bank_name = $attributes['bank_name'];
        }
        if (array_key_exists('cheque_no', $attributes)) {
            $cheque_no = $attributes['cheque_no'];
        }
        if (array_key_exists('paybill_number', $attributes)) {
            $paybill_number = $attributes['paybill_number'];
        }
        if (array_key_exists('trans_id', $attributes)) {
            $mpesa_code = $attributes['trans_id'];
            $trans_id = $attributes['trans_id'];
        }
        if (array_key_exists('payment_at', $attributes)) {
            $payment_at = $attributes['payment_at'];
            $payment_at = getGMTDate($payment_at);
            $attributes['payment_at'] = $payment_at;
        }
        if (array_key_exists('payment_method_id', $attributes)) {
            $payment_method_id = $attributes['payment_method_id'];
        } else {
            $payment_method_id = $mpesa_payment_id;
        }
        if (array_key_exists('transfer', $attributes)) {
            $transfer = $attributes['transfer'];
        }
        if (array_key_exists('tran_ref_txt', $attributes)) {
            $tran_ref_txt = $attributes['tran_ref_txt'];
        }
        if (array_key_exists('tran_desc', $attributes)) {
            $tran_desc = $attributes['tran_desc'];
        }
        if (array_key_exists('payment_type', $attributes)) {
            $payment_type = $attributes['payment_type'];
        }
        if (array_key_exists('amount', $attributes)) {
            $amount = $attributes['amount'];
        }
        if (array_key_exists('full_name', $attributes)) {
            $full_name = $attributes['full_name'];
        }
        if (array_key_exists('phone_number', $attributes)) {
            $phone_number = $attributes['phone_number'];
            $attributes['phone'] = $attributes['phone_number'];
        }
        if (array_key_exists('acct_no', $attributes)) {
            $account_no = $attributes['acct_no'];
            $attributes['account_no'] = $attributes['acct_no'];
        }
        if (array_key_exists('destination_account_type', $attributes)) {
            $destination_account_type = $attributes['destination_account_type'];
        }
        // dd("heye attributes == ", $attributes);

        if (!$payment_method_id) {
            $payment_method_id = getPaymentMethodMpesa();
        }
        // dd("payment_method_id == ", $payment_method_id);

        // get settings_company_id
        // $site_settings = getSiteSettings();

        // read new_payment object
        // $payment_id = $new_payment->id;

        // start transaction
        DB::beginTransaction();

            // if we are in transfer mode
            if ($transfer) {

                // start if we are transferring to a wallet account
                if ($destination_account_type == getAccountTypeWalletAccount()) {

                    // save amount to user deposit account
                    $paymentUserDepositAccountStore = new PaymentUserTransferStore();

                    try {

                        $result = $paymentUserDepositAccountStore->createItem($attributes, $new_payment);
                        log_this("Success paymentUserDepositAccountStore \n" . json_encode($result));

                        // dd("result == ", $result);

                    } catch(\Exception $e) {

                        $error_message = $e->getMessage();
                        log_this("Error paymentUserDepositAccountStore \n" . json_encode($error_message));
                        throw new \Exception($error_message);

                    }

                }
                // end if we are transferring to a wallet account

                // start if we are transferring to a transaction account
                if ($destination_account_type == getAccountTypeTransactionAccount()) {

                    // save amount to transaction account
                    $paymentTransactionTransferStore = new PaymentTransactionTransferStore();

                    try {

                        $result = $paymentTransactionTransferStore->createItem($attributes, $new_payment);
                        log_this("Success paymentTransactionTransferStore \n" . json_encode($result));

                        // dd("result == ", $result);

                    } catch(\Exception $e) {

                        // dd($e);
                        $error_message = $e->getMessage();
                        log_this("Error paymentTransactionTransferStore \n" . json_encode($error_message));
                        throw new \Exception($error_message);

                    }

                }
                // end if we are transferring to a transaction account



            }

            // if account_no exists and we are not in transfer mode
            if ($account_no && !$transfer) {

                // save amount to user deposit account
                $paymentUserDepositAccountStore = new PaymentUserDepositAccountStore();

                try {

                    $attributes['deposit_amount'] = $amount;

                    $result = $paymentUserDepositAccountStore->createItem($attributes, $new_payment);
                    log_this("Success paymentUserDepositAccountStore \n" . json_encode($result));

                    // dd("result == ", $result);

                } catch(\Exception $e) {

                    throw new \Exception($e->getMessage());

                }

            }

        DB::commit();

        $message = "Successful";
        return show_success_response($message);

    }

}
