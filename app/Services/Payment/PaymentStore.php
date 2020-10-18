<?php

namespace App\Services\Payment;

use App\Entities\Payment;
use App\Entities\PaymentDeposit;
use App\Services\Shares\SharesDepositStore;
use App\Services\Payment\PaymentDepositStore;
use App\Services\LoanRepayment\LoanRepaymentStore;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Facades\DB;

class PaymentStore
{

    public function createItem($attributes, $new_payment) {

        // dd($attributes, $new_payment);

        $repost = false;
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
        $payment_id = "";
        $tran_ref_txt = "";

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
        if (array_key_exists('tran_ref_txt', $attributes)) {
            $tran_ref_txt = $attributes['tran_ref_txt'];
        }
        if (array_key_exists('tran_desc', $attributes)) {
            $tran_desc = $attributes['tran_desc'];
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

        // get barddy_company_id
        $site_settings = getSiteSettings();
        $barddy_company_id = $site_settings['barddy_company_id'];
        $barddy_company_name = $site_settings['company_name_title'];
        $barddy_company_phone = $site_settings['contact_phone'];

        // read new_payment object
        $payment_id = $new_payment->id;
        // dd($payment_id);

        //start transaction
        DB::beginTransaction();

            ////////////////////////////////////
            $deposit_amount = $amount;
            $balance_amount = 0;
            $payment_amount = $amount;
            $currency_id = NULL;
            $offer_id = NULL;
            $email = "";
            $first_name = "";

            // get order data i.e amount to be paid
            if ($account_no) {

                $statuses_array = array();
                $statuses_array[] = getStatusOrderPlaced();
                $statuses_array[] = getStatusActive();
                $order_data = getShoppingCart("", "", $account_no, $statuses_array);
                // dd("gogo ", $order_data);

                // get total to be paid from order
                $paid_amount_total = $order_data->paid_amount_calc;
                $balance_total = $order_data->balance_calc;
                $currency_id = $order_data->currency_id;
                $offer_id = $order_data->offer_id;
                // dd($payment_id, $order_data);

                // get user data
                $user_data = $order_data->user;
                if ($user_data) {
                    $email = $user_data->email;
                    $first_name = $user_data->first_name;
                }

                // check if there is balance after payment
                // set $fully_paid appropriately
                $fully_paid = false;
                if ($amount > $balance_total) {
                    $deposit_amount = $amount - $balance_total;
                    $payment_amount = $balance_total;
                    $balance_amount = 0;
                }
                if ($amount == $balance_total) {
                    $deposit_amount = 0;
                    $payment_amount = $balance_total;
                    $balance_amount = 0;
                }
                if ($amount < $balance_total) {
                    $deposit_amount = 0;
                    $payment_amount = $amount;
                    $balance_amount = $balance_total - $amount;
                }
                $paid_amount = $paid_amount_total + $payment_amount;

                if (($amount > $balance_total) || ($amount == $balance_total)) {
                    $fully_paid = true;
                }

                /* dump("deposit_amount", $deposit_amount);
                dump("balance_amount", $balance_amount);
                dump("payment_amount", $payment_amount);
                dd("paid_amount", $paid_amount); */

                $company_data = $order_data->company;
                $company_id = $company_data->id;
                $company_name = $company_data->name;
                $company_phone = $company_data->company_phone;
                $company_website = $company_data->website;
                // dd("paid_amount", $paid_amount);

                // if fully paid
                if ($fully_paid) {

                    // change shopping cart status id
                    try {

                        submitShoppingCartPayment($account_no);
                        // dd("end");

                    } catch(\Exception $e) {

                        DB::rollback();
                        // dd($e);
                        log_this(json_encode($e));
                        $message = "An error occured. Could not complete order.";
                        return show_error_response($message);

                    }

                    // create entry in completed orders table
                    try {

                        createOrderFromShoppingCart($account_no, $payment_id);

                    } catch(\Exception $e) {

                        DB::rollback();
                        // dd($e);
                        log_this(json_encode($e));
                        $message = "An error occured. Could not complete order.";
                        return show_error_response($message);

                    }

                    // TODO:: create reports data - completed order

                }

                // set tran_ref_txt && tran_desc
                if (!$tran_ref_txt) {
                    $tran_ref_txt = "Payment for order id - $account_no, mpesa code: $trans_id";
                }
                if (!$tran_desc) {
                    $tran_desc = "Payment for order id - $account_no, mpesa code: $trans_id, paid by: $full_name";
                }

            }
            // dd($tran_ref_txt, $tran_desc);

            // set tran_ref_txt && tran_desc if account_no is absent
            if (!$tran_ref_txt) {
                $tran_ref_txt = "mpesa code: $trans_id";
            }
            if (!$tran_desc) {
                $tran_desc = "mpesa code: $trans_id, paid by: $full_name";
            }
            // dd($payment_amount, $balance_amount, $paid_amount_total, $order_data);

            // if paid in excess, store extra in user deposit account
            $external_result = "";

            // if payment_amount is more than 0, reduce order balance by this
            if ($payment_amount > 0) {

                // reduce the order balance
                try{

                    // update the balance
                    $order_data->balance = -$balance_amount;
                    $order_data->balance_calc = $balance_amount;
                    $order_data->paid_amount = -$paid_amount;
                    $order_data->paid_amount_calc = $paid_amount;
                    $res = $order_data->save();
                    // dd($res);

                    /* log_this("\n\n\n************** order_data_update ************* \n\n"
                    . $order_data->id
                    . "\n\n*******************************************\n\n"); */

                } catch(\Exception $e) {

                    DB::rollback();
                    // dd($e);
                    $error_message = $e->getMessage();

                    if (!$transfer) {
                        Payment::find($payment_id)
                            ->update([
                                'fail_reason' => $error_message,
                                'failed' => '1',
                                'failed_at' => $date
                            ]);
                    }

                    // if trans is not being reposted by admin, show error msg
                    if (!$repost) {

                        // if not reposting, send error message to user
                        // start create sms message
                        $message = "Dear " . titlecase($full_name) . ", we could not process your order at this time. ";
                        $message .= "Please call: $company_phone ";
                        // $message .= " or dial *533# and choose help";
                        if ($company_website) { $message .= " or visit $company_website"; } //show if company has a website
                        $message .= " for assistance. Thank you. $company_name Team.";
                        // end create sms message

                        $params['sms_message']      = $message;
                        $params['phone_number']     = $phone_number;
                        $params['company_id']     = $barddy_company_id();

                        // start send sms
                        /* $response_sms = createSmsOutbox($message, $phone_number, getCompanySmsType(), $barddy_company_id);
                        log_this(json_encode($response_sms)); */
                        // end send sms

                    }

                    return show_error_response($error_message);

                }
                // end if payment_amount is more than 0, reduce order balance by this


            }
            // dd("after payment");

            //start create new payment deposit item
            try{

                $paymentDepositStore = new PaymentDepositStore();

                $attributes['amount'] = $payment_amount;
                $attributes['account_no'] = $account_no;
                $attributes['mpesa_code'] = $trans_id;
                $attributes['payment_id'] = $payment_id;
                $attributes['payment_name'] = $full_name;
                $attributes['tran_ref_txt'] = $tran_ref_txt;
                $attributes['tran_desc'] = $tran_desc;
                $attributes['fully_paid'] = $fully_paid;
                $attributes['deposit_amount'] = $deposit_amount;

                $external_result = $paymentDepositStore->createItem($payment_id, $attributes);
                log_this("\n\n\n************** PAYMENT STORE ************* \n\n"
                . json_encode($external_result)
                . "\n\n*******************************************\n\n");

                // dd("external_result here", $external_result);

                $external_result = json_decode($external_result);
                // dd($external_result);

                // TODO:: create reports data - new payment

            } catch(\Exception $e) {

                DB::rollback();
                // dd($e);
                $error_message = $e->getMessage();

                if (!$transfer) {
                    Payment::find($payment_id)
                        ->update([
                            'fail_reason' => $error_message,
                            'failed' => '1',
                            'failed_at' => $date
                        ]);
                }

                // if trans is not being reposted by admin, show error msg
                if (!$repost) {

                    // if not reposting, send error message to user
                    // start create sms message
                    $message = "Dear " . titlecase($full_name) . ", we could not process your order at this time. ";
                    $message .= "Please call: $company_phone ";
                    // $message .= " or dial *533# and choose help";
                    if ($company_website) { $message .= " or visit $company_website"; } //show if company has a website
                    $message .= " for assistance. Thank you. $company_name Team.";
                    // end create sms message

                    $params['sms_message']      = $message;
                    $params['phone_number']     = $phone_number;
                    $params['company_id']     = $barddy_company_id();

                    // start send sms
                    /* $response_sms = createSmsOutbox($message, $phone_number, getCompanySmsType(), $barddy_company_id);
                    log_this(json_encode($response_sms)); */
                    // end send sms

                }

                return show_error_response($error_message);

            }
            // end create new payment deposit item
            // dd("after deposit");

            if ($external_result) {

                // set order company data
                $company_id = "";
                $company_name = "";
                $company_phone = "";

                $account = $external_result->deposit_account;
                // $user = $account->user;

                $dep_account_no = $account->account_no;
                $account_name = $account->account_name;

                if ($company_data) {
                    $company_id = $company_data->id;
                    $company_name = $company_data->name;
                    $company_phone = $company_data->phone;
                }

                //update record
                if (!$transfer) {
                    Payment::find($payment_id)
                        ->update([
                            'company_id' => $company_id,
                            'company_name' => $company_name,
                            'account_no' => $account_no,
                            'account_name' => $account_name,
                            'processed' => '1',
                            'processed_at' => $date
                        ]);
                    //end update payment record

                    $payment_deposit = new PaymentDeposit();

                        $payment_deposit_attributes['payment_id'] = $payment_id;
                        $payment_deposit_attributes['company_id'] = $company_id;
                        $payment_deposit_attributes['company_name'] = $company_name;
                        $payment_deposit_attributes['account_no'] = $account_no;
                        $payment_deposit_attributes['account_name'] = $account_name;
                        $payment_deposit_attributes['processed'] = "1";
                        $payment_deposit_attributes['processed_at'] = $date;
                        $payment_deposit_attributes['amount'] = $amount;
                        $payment_deposit_attributes['currency_id'] = $currency_id;
                        $payment_deposit_attributes['payment_method_id'] = $payment_method_id;
                        $payment_deposit_attributes['paybill_number'] = $paybill_number;
                        $payment_deposit_attributes['phone'] = $attributes['phone'];
                        $payment_deposit_attributes['full_name'] = $full_name;
                        $payment_deposit_attributes['trans_id'] = $trans_id;
                        $payment_deposit_attributes['src_ip'] = $attributes['src_ip'];
                        $payment_deposit_attributes['trans_time'] = $date;
                        $payment_deposit_attributes['date_stamp'] = $date;
                        // $payment_deposit_attributes['modified'] = $modified;
                        // $payment_deposit_attributes['reposted_at'] = $reposted_at;
                        // $payment_deposit_attributes['reposted_by'] = $reposted_by;

                    $payment_deposit->create($payment_deposit_attributes);

                }
                //end save payment deposit record

            }
            //end if payment was successfully updated

            // send user email/ sms
            // if order payment was made
            if ($payment_amount > 0) {

                $amount_fmt = formatCurrency($amount);
                $balance_amount_fmt = formatCurrency($balance_amount);
                $message = "Dear $full_name, thank you for your payment of: $amount_fmt for order id: $account_no, paid to $company_name. ";

                if ($balance_amount > 0) {
                    $message .= "Please complete balance payment of : $balance_amount_fmt to finalize your order. ";
                }

                if ($balance_amount == 0) {
                    if ($offer_id) {
                        $offer_end_data = getOfferData($offer_id);
                        $offer_end_date = $offer_end_data->expiry_at;
                        $offer_end_date_fmt = formatFriendlyDate($offer_end_date);
                    }
                    $message .= "You order is ready. ";
                    if ($offer_end_date) {
                        $message .= "Organize and pick your drinks on $offer_end_date_fmt ";
                    }
                }
                $message .= "Regards, $barddy_company_name Team";

                // dd($message);

                // send sms
                // $result = createSmsOutbox($message, $phone_number, getCompanySmsType(), $company_id);
                // log_this(json_encode($result));

                // TODO:: send email to client

            }

            // if order was paid in excess
            if ($deposit_amount > 0) {

                $deposit_amount_fmt = formatCurrency($deposit_amount);
                $wallet_message = "Dear $full_name, thank you for your payment. $deposit_amount_fmt has been saved to your $barddy_company_name wallet.";
                $wallet_message .= "Regards, $barddy_company_name Team";

                // dd($wallet_message);

                // send sms
                // $result = createSmsOutbox($wallet_message, $phone_number, getCompanySmsType(), $company_id);
                // log_this(json_encode($result));

                // TODO:: send email to client

            }
            // dd($message, $wallet_message);

            /* if ($transfer) {
                $sms_message = "Dear $full_name_fmt, $amount_fmt has been transferred from your deposits ";
                $sms_message .= " to pay for order id: $account_no successfully.";
                $sms_message .= " Thank you for using $company_name. Helpline: $company_phone";
            } else {
                $sms_message = sprintf("Dear %s, your payment of %s to account: %s has been successful. Thank you for using %s. Helpline: %s",
                                $full_name_fmt, $amount_fmt, $account_name, $company_name, $company_phone);
            } */

            /* $sms_message = sprintf("Dear %s, your payment of %s to account: %s has been successful. Thank you for using %s. Helpline: %s",
                                $full_name_fmt, $amount_fmt, $account_name, $barddy_company_name, $barddy_company_phone);
            //send sms
            $result = createSmsOutbox($sms_message, $phone_number, getCompanySmsType(), $company_id);
            log_this(json_encode($result)); */
            //end send success sms message

            // send email
            /* if ($email) {

                //start send email to queue
                $subject = 'Dear ' . $first_name . ', Successful payment to your account at ' . $barddy_company_name;
                $title = $subject;

                $email_salutation = "Dear " . $first_name . ",<br><br>";

                $email_text = "Deposit of <strong>" . formatCurrency($amount) . "</strong> has been made to your account at " . $barddy_company_name;
                $email_text .= "via paybill no. $paybill_number.<br><br>";
                $email_text .= "Payment details are as follows: <br><br>";

                $panel_text = "Sender Full Name: <strong>" . titlecase($full_name) . "</strong><br>";
                $panel_text .= "Sender Phone: <strong>" . $phone_number . "</strong><br>";
                $panel_text .= "Amount: <strong>" . formatCurrency($amount) . "</strong><br>";
                $panel_text .= "Your Account Name: <strong>" . titlecase($account_name) . "</strong><br><br>";

                $email_footer = "Regards,<br>";
                $email_footer .= "$barddy_company_name Management";

                //email queue
                $table_text = "";

                $parent_id = 0;
                $reminder_message_id = 0;

                $result = sendTheEmailToQueue($email, $subject, $title, $company_name, $email_text, $email_salutation,
                $company_id, $email_footer, $panel_text, $table_text, $parent_id, $reminder_message_id);
                //end send email to queue

            } */
            //************************* end update payment *********************************** */

        DB::commit();

        return show_json_success($external_result);

    }

}
