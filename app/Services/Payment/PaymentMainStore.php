<?php

namespace App\Services\Payment;

use App\Entities\Payment;

class PaymentMainStore
{

    public function createItem($attributes) {

        // dd("attributes === ", $attributes);

        $mpesa_payment_id = getPaymentMethodMpesa();

        $cash_payment_id = config('constants.payment_methods.cash');
        $bank_payment_id = config('constants.payment_methods.bank');
        $cheque_payment_id = config('constants.payment_methods.cheque');

        $date = getCurrentDate(1);

        $paybill_number = "";
        $account_no = "";
        $trans_id = "";
        $tran_desc = "";
        $bank_name = "";
        $cheque_no = "";
        $mpesa_code = "";
        $payment_at = "";
        $payment_method_id = "";
        $transfer = "";

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
        /* if (array_key_exists('transfer', $attributes)) {
            $transfer = $attributes['transfer'];
        }
        if (array_key_exists('bank_name', $attributes)) {
            $bank_name = $attributes['bank_name'];
        }
        if (array_key_exists('payment_type', $attributes)) {
            $payment_type = $attributes['payment_type'];
        }
        if (array_key_exists('amount', $attributes)) {
            $amount = $attributes['amount'];
        }
        if (array_key_exists('full_name', $attributes)) {
            $full_name = $attributes['full_name'];
        } */
        if (array_key_exists('phone_number', $attributes)) {
            $phone_number = $attributes['phone_number'];
            $attributes['phone'] = $phone_number;
        }
        if (array_key_exists('acct_no', $attributes)) {
            $account_no = $attributes['acct_no'];
            $attributes['account_no'] = $account_no;
        }

        // START check the payment method params exist i.e. bank, mpesa, cash or cheque
        if ($payment_method_id == $mpesa_payment_id) {

            //check for mpesa params
            if (!$mpesa_code) {
                $show_message = trans('general.missingmpesacode');
                log_this($show_message);
                throw new \Exception($show_message);
            }
            if (!$paybill_number) {
                $show_message = trans('general.missingpaybillnumber');
                log_this($show_message);
                throw new \Exception($show_message);
            }
            // check if mpesa id has already been used
            if (isMpesaCodeUsed($mpesa_code)) {
                $show_message = trans('general.usedmpesacode');
                log_this($show_message);
                throw new \Exception($show_message);
            }
        }

        // init payment_id
        $payment_id = NULL;

        // if we are not in repost mode
        if ((!array_key_exists('id', $attributes))) {

            //create new payment
            try {
                $payment = new Payment();
                $payment_result = $payment->create($attributes);
                // dd("payment_result === ", $payment_result);
                $payment_id = $payment_result->id;
            } catch(\Exception $e) {
                // dd($e);
                $show_message = trans('general.couldnotcreatepayment');
                log_this($show_message . " - " . $e->getMessage());
                throw new \Exception($show_message);
            }

        }

        $reponse = [];

        if ($payment_id) {
            $reponse = Payment::find($payment_id);
        }

        return show_success_response($reponse);

    }

}
