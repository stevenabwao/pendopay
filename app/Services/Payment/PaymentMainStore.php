<?php

namespace App\Services\Payment;

use App\Entities\Payment;
use Carbon\Carbon;

class PaymentMainStore
{

    public function createItem($attributes) {

        // dd($attributes);

        $mpesa_payment_id = config('constants.payment_methods.mpesa');
        $cash_payment_id = config('constants.payment_methods.cash');
        $bank_payment_id = config('constants.payment_methods.bank');
        $cheque_payment_id = config('constants.payment_methods.cheque');

        $date = getCurrentDate(1);
        // dd($date);

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
        }
        if (array_key_exists('transfer', $attributes)) {
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
        }
        if (array_key_exists('phone', $attributes)) {
            $phone_number = $attributes['phone'];
        }
        if (array_key_exists('account_no', $attributes)) {
            $account_no = $attributes['account_no'];
        } else {
            $account_no = $attributes['phone'];
            $attributes['account_no'] = $attributes['phone'];
        }

        // get barddy phone
        // $site_settings = getSiteSettings();
        // $barddy_contact_phone = $site_settings['contact_phone'];

        //START check the payment method params exist i.e. bank, mpesa, cash or cheque
        if ($payment_method_id == $mpesa_payment_id) {
            //check for mpesa params
            if (!$mpesa_code) {
                $show_message = "Please enter mpesa code";
                log_this($show_message);
                $message["message"] = $show_message;
                return show_error_response($message);
            }
            if (!$paybill_number) {
                $show_message = "Please enter paybill number";
                log_this($show_message);
                $message["message"] = $show_message;
                return show_error_response($message);
            }
            // check if mpesa id has already been used
            if (isMpesaCodeUsed($mpesa_code)) {
                // show error
                $show_message = "Invalid mpesa code";
                log_this($show_message);
                $message["message"] = $show_message;
                return show_error_response($message);
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
                $payment_id = $payment_result->id;
            } catch(\Exception $e) {
                $show_message = "Could not create payment";
                log_this($show_message . " - " . $e->getMessage());
                $message["message"] = $show_message;
                return show_error_response($message);
            }

        }

        // get order and company data
        if ($account_no) {
            $statuses_array = array();
            $statuses_array[] = getStatusOrderPlaced();
            $statuses_array[] = getStatusActive();

            $order_data = getShoppingCart("", "", $account_no, $statuses_array);
            // dd($order_data);
            // get company details from order
            $company_data = $order_data->company;
            $company_id = $company_data->id;
            $company_name = $company_data->name;
            $company_short_name = $company_data->short_name;

            // if not in transfer mode, update company details
            if (!$transfer) {
                if ($company_id && $payment_id) {
                    // update
                    try {
                        Payment::find($payment_id)
                            ->update([
                                'company_id' => $company_id,
                                'company_name' => $company_name
                            ]);
                    } catch (\Exception $e) {
                        $show_message = "Could not update payment";
                        log_this($show_message . " - " . $e->getMessage());
                        $message["message"] = $show_message;
                        return show_error_response($message);
                    }
                }
            }
        }

        $reponse = "";
        if ($payment_id) {
            $reponse = Payment::find($payment_id);
        }

        return show_success_response($reponse);

    }

}
