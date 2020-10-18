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

        $order_id = "";
        $amount = "";
        $payment_mode = "";
        $phone_number = "";
        $user_id = "";

        if (array_key_exists('order_id', $attributes)) {
            $order_id = $attributes['order_id'];
            $account_no = $order_id;
        }
        if (array_key_exists('amount', $attributes)) {
            $amount = $attributes['amount'];
        }
        if (array_key_exists('payment_mode', $attributes)) {
            $payment_mode = $attributes['payment_mode'];
        }
        if (array_key_exists('phone_number', $attributes)) {
            $phone_number = $attributes['phone_number'];
            $phone_number = getDatabasePhoneNumber($phone_number);
        }
        if (array_key_exists('user_id', $attributes)) {
            $user_id = $attributes['user_id'];
        }
        // dd($attributes);

        // barddy paybill
        $site_settings = getSiteSettings();
        $barddy_paybill_number = $site_settings['barddy_paybill_number'];

        // get company id
        $shopping_cart_data = getShoppingCart($user_id, "", $order_id);
        $company_id = $shopping_cart_data->company_id;
        // dd($company_id, $shopping_cart_data);

        // get company data
        /* if ($barddy_paybill_number) {
            // calc
        } */

        //start transaction
        DB::beginTransaction();

            ////////////////////////////////////
            $repayment_amount = 0;
            $deposit_amount = 0;

            //if account_no is entered, use the submitted account_no/ phone
            $account_data = getUserData($account_no);

            // dd($account_data, $company_id, $phone_number);

            if (!$account_data) {

                // show error
                $error_message = "User Account not found";
                     return show_json_error($error_message);

            }

            $external_result = "";

            //check if we are sending to shares account
            if ($shares) {

                //send to shares account
                //start create new payment deposit item
                try{

                    $sharesStore = new SharesDepositStore();

                    //set attributes
                    $attributes['mpesa_code'] = $trans_id;
                    $attributes['payment_id'] = $payment_id;
                    $attributes['payment_name'] = titlecase($full_name);

                    //dd($attributes);

                    $external_result = $sharesStore->createItem($payment_id, $attributes);
                    log_this("\n\n\n************** PAYMENT STORE ************* \n\n"
                    . json_encode($external_result)
                    . "\n\n*******************************************\n\n");

                    //dd($external_result);

                } catch(\Exception $e) {

                    DB::rollback();
                    $error_message = $e->getMessage();

                    if (!$transfer) {
                        $payment_update = Payment::find($payment_id)
                            ->update([
                                'fail_reason' => $error_message,
                                'failed' => '1',
                                'failed_at' => $date
                            ]);
                    }

                    //dd($e->getMessage());

                    //if trans is not being reposted by admin, show error msg
                    if ((!$repost) && (!$transfer)) {

                        //if not reposting, send error message to user
                        //start create sms message
                        $message = "Dear " . titlecase($full_name) . ", the account you have entered: $top_account_no cannot be found. ";
                        $message .= "Please call: $company_phone ";
                        $message .= " or dial *533# and choose help";
                        if ($company_website) { $message .= " or visit $company_website"; } //show if company has a website
                        $message .= ". Thank you. $company_short_name Team.";
                        //end create sms message

                        $params['sms_message']      = $message;
                        $params['phone_number']     = $phone_number;
                        $params['company_id']     = $company_id;

                        //send sms
                        $response_sms = sendApiSms($params);
                        //end send  sms message

                    }

                    return show_json_error($error_message);

                }
                //end create new payment shares item

            } else {

                //if account exists, check loans balances
                if ($account_data) {

                    $company_user_id = $account_data->id;
                    $user_id = $account_data->user_id;

                    //dd($company_user_id, $user_id);

                    //check if user has active loan in company
                    $status_open = config('constants.status.open');
                    $status_unpaid = config('constants.status.unpaid');

                    $user_loan_data = getUserIncompletedLoan($company_user_id, $company_id);

                    //if user has balance, repay here
                    if ($user_loan_data) {

                        $loan_bal = $user_loan_data->loan_bal_calc;
                        $loan_account_id = $user_loan_data->id;

                        //if payment is more than loan_bal, save the extra into user deposit account
                        if ($amount > $loan_bal) {

                            //save extras
                            $repayment_amount = $loan_bal;

                            //set new amount
                            $deposit_amount = $amount - $loan_bal;

                        } else {

                            $repayment_amount = $amount;

                        }

                    } else {

                        $deposit_amount = $amount;

                    }

                }

                //dd($deposit_amount, $repayment_amount);

                //if amount balance exists, proceed
                if (($deposit_amount > 0) && ($account_data)) {

                    //start create new payment deposit item
                    try{

                        $paymentDepositStore = new PaymentDepositStore();

                        //replace amount with new deposit_amount
                        $attributes['amount'] = $deposit_amount;
                        $attributes['mpesa_code'] = $trans_id;
                        $attributes['payment_id'] = $payment_id;
                        $attributes['payment_name'] = titlecase($full_name);
                        $attributes['tran_ref_txt'] = $tran_ref_txt;
                        $attributes['tran_desc'] = $tran_desc;

                        //dd($attributes);

                        $external_result = $paymentDepositStore->createItem($payment_id, $attributes);
                        log_this("\n\n\n************** PAYMENT STORE ************* \n\n"
                        . json_encode($external_result)
                        . "\n\n*******************************************\n\n");

                        //dd($external_result);

                        //return $payment_deposit_result;

                        //$result_data = show_json_success($payment_deposit_result);
                        //$response['deposit'] = $payment_deposit_result;

                    } catch(\Exception $e) {

                        DB::rollback();
                        $error_message = $e->getMessage();

                        if (!$transfer) {
                            $payment_update = Payment::find($payment_id)
                                ->update([
                                    'fail_reason' => $error_message,
                                    'failed' => '1',
                                    'failed_at' => $date
                                ]);
                        }

                            //dd($e->getMessage());

                        //if trans is not being reposted by admin, show error msg
                        if (!$repost) {

                            //if not reposting, send error message to user
                            //start create sms message
                            $message = "Dear " . titlecase($full_name) . ", the account you have entered: $top_account_no cannot be found. ";
                            $message .= "Please call: $company_phone ";
                            $message .= " or dial *533# and choose help";
                            if ($company_website) { $message .= " or visit $company_website"; } //show if company has a website
                            $message .= ". Thank you. $company_short_name Team.";
                            //end create sms message

                            $params['sms_message']      = $message;
                            $params['phone_number']     = $phone_number;
                            $params['company_id']     = $company_id;

                            //send sms
                            $response_sms = sendApiSms($params);
                            //end send  sms message

                        }

                        return show_json_error($error_message);

                    }
                    //end create new payment deposit item

                }

                //dd($amount, $repayment_amount);

                //if repayment amount exists, save loan repayment
                if (($repayment_amount > 0) && ($account_data)) {

                    try {

                        //create repayment entry here
                        $loanRepaymentStore = new LoanRepaymentStore();

                        $repay_attributes['company_user_id'] = $company_user_id;
                        $repay_attributes['user_id'] = $user_id;
                        $repay_attributes['company_id'] = $company_id;
                        $repay_attributes['phone'] = $phone_number;
                        $repay_attributes['account_no'] = $account_no;
                        $repay_attributes['amount'] = $repayment_amount;
                        $repay_attributes['mpesa_code'] = $trans_id;
                        $repay_attributes['payment_id'] = $payment_id;
                        $repay_attributes['payment_name'] = titlecase($full_name);
                        $repay_attributes['transfer'] = $transfer;
                        $repay_attributes['tran_ref_txt'] = $tran_ref_txt;
                        $repay_attributes['tran_desc'] = $tran_desc;

                        $external_result = $loanRepaymentStore->createItem($repay_attributes);
                        log_this("\n\n\n************** PAYMENT STORE ************* \n\n"
                        . json_encode($external_result)
                        . "\n\n*******************************************\n\n");

                    } catch(\Exception $e) {

                        DB::rollback();
                        $show_message = $e->getMessage();
                        //dd($show_message);
                        log_this($show_message);
                        $message["message"] = $show_message;
                        return show_json_error($message);

                    }

                }

            }

            //************************* start update payment *********************************** */

            //start if payment was successfully updated

            //dd($deposit_amount, $repayment_amount, $external_result);

            if ($external_result) {

                //update payment record
                $external_result = json_decode($external_result);
                //dd($external_result);

                $company = $external_result->company;
                $account = $external_result->account;
                $company_user = $external_result->company_user;
                $company_id = $company->id;
                $company_name = $company->name;
                $company_short_name = $company->short_name;
                $company_phone = $company->phone;
                $account_no = $account->account_no;
                $account_name = titlecase($account->account_name);
                $company_user_id = $company_user->id;

                //update record
                if (!$transfer) {
                    $payment_update = Payment::find($payment_id)
                        ->update([
                            'company_id' => $company_id,
                            'company_name' => $company_name,
                            'account_no' => $account_no,
                            'account_name' => $account_name,
                            'processed' => '1',
                            'processed_at' => $date
                        ]);
                    //end update payment record

                    //start save payment deposit record
                    $amount = $payment_result->amount;
                    $currency_id = $payment_result->currency_id;
                    $payment_method_id = $payment_result->payment_method_id;
                    $paybill_number = $payment_result->paybill_number;
                    $phone = $payment_result->phone;
                    $full_name = titlecase($payment_result->full_name);
                    $trans_id = $payment_result->trans_id;
                    $src_ip = $payment_result->src_ip;
                    $trans_time = $payment_result->trans_time;
                    $date_stamp = $payment_result->date_stamp;
                    $comments = $payment_result->comments;
                    $modified = $payment_result->modified;
                    $reposted_at = $payment_result->reposted_at;
                    $reposted_by = $payment_result->reposted_by;
                    $created_by = $payment_result->created_by;
                    $updated_by = $payment_result->updated_by;

                    $payment_deposit = new PaymentDeposit();

                        $payment_deposit->payment_id = $payment_id;
                        $payment_deposit->company_id = $company_id;
                        $payment_deposit->company_name = $company_name;
                        $payment_deposit->account_no = $account_no;
                        $payment_deposit->account_name = $account_name;
                        $payment_deposit->processed = "1";
                        $payment_depositzprocessed_at = $date;
                        $payment_deposit->amount = $amount;
                        $payment_deposit->currency_id = $currency_id;
                        $payment_deposit->payment_method_id = $payment_method_id;
                        $payment_deposit->paybill_number = $paybill_number;
                        $payment_deposit->phone = $phone;
                        $payment_deposit->full_name = titlecase($full_name);
                        $payment_deposit->trans_id = $trans_id;
                        $payment_deposit->src_ip = $src_ip;
                        $payment_deposit->trans_time = $trans_time;
                        $payment_deposit->date_stamp = $date_stamp;
                        $payment_deposit->modified = $modified;
                        $payment_deposit->reposted_at = $reposted_at;
                        $payment_deposit->reposted_by = $reposted_by;

                    $payment_deposit->save();
                }
                //end save payment deposit record

            } else {

                $account_name = $account_no;

            }

            //end if payment was successfully updated


            //dd($payment_deposit_result);

            //start send success sms message
            //dd($attributes);

            if ($company_phone) {
                $snb_helpline = $company_phone;
            }

            if ($company_short_name) {
                $company_name = $company_short_name;
            } else {
                $company_name = $snb_company_name;
            }

            $amount_fmt = formatCurrency($amount);
            $full_name_fmt = titlecase($full_name);

            if ($transfer) {
                $sms_message = "Dear $full_name_fmt, $amount_fmt has been transferred from your $source_account_text:$source_account_phone";
                $sms_message .= " to $destination_account_text: $destination_account_phone ($account_name) successfully.";
                $sms_message .= " Thank you for using $company_name. Helpline: $snb_helpline";
            } else {
                if ($shares) {
                    $sms_message = sprintf("Dear %s, your payment of %s to shares account: %s has been successful. Thank you for using %s. Helpline: %s",
                                    $full_name_fmt, $amount_fmt, $account_name, $company_name, $snb_helpline);
                } else {
                    $sms_message = sprintf("Dear %s, your payment of %s to account: %s has been successful. Thank you for using %s. Helpline: %s",
                                    $full_name_fmt, $amount_fmt, $account_name, $company_name, $snb_helpline);
                }
            }

            //send sms
            $result = createSmsOutbox($sms_message, $phone_number, $sms_type_id, $company_id);
            //end send success sms message

            if (!$transfer) {
                //start send account owner email on transaction
                //get payment record
                $payment = Payment::find($payment_id);
                //dd($payment->account->companyuser->user);
                //find account owner email
                if ($payment->account) {
                    if ($payment->account->companyuser) {
                        if ($payment->account->companyuser->user) {
                            $email = $payment->account->companyuser->user->email;

                            $first_name = titlecase($payment->account->companyuser->user->first_name);
                            $last_name = titlecase($payment->account->companyuser->user->last_name);
                            $payment_amount = $payment->amount;
                            $company_name = $payment->account->companyuser->company->name;
                            $company_id = $payment->account->companyuser->company->id;
                            $local_phone = $payment->account->companyuser->user->phone;
                            $phone_country = $payment->account->companyuser->user->phone_country;
                            $user_phone = getDatabasePhoneNumber($local_phone, $phone_country);
                            $localised_phone = getLocalisedPhoneNumber($local_phone, $phone_country);

                            $company_short_name = $payment->account->companyuser->company->short_name;
                            if (!$company_short_name) {
                                $company_short_name = $company_name;
                            }

                            //start get main paybill no
                            $mpesa_paybill = $payment->paybill_number;
                            //end get main paybill no

                            if ($email) {

                                //Mail::to($email)
                                //    ->send(new NewUserPayment($payment));

                                //start send email to queue
                                $subject = 'Dear ' . $first_name . ', Successful Deposit to your Account at  ' . $company_short_name;
                                $title = $subject;

                                $email_salutation = "Dear " . $first_name . ",<br><br>";

                                $email_text = "Deposit of <strong>" . formatCurrency($payment_amount) . "</strong> has been made to your account at $company_name ";
                                $email_text .= "via paybill no. $paybill_number.<br><br>";
                                $email_text .= "Payment details are as follows: <br><br>";

                                $panel_text = "Sender Full Name: <strong>" . titlecase($payment->full_name) . "</strong><br>";
                                $panel_text .= "Sender Phone: <strong>" . $payment->phone . "</strong><br>";
                                $panel_text .= "Amount: <strong>" . formatCurrency($payment->amount) . "</strong><br>";
                                $panel_text .= "Your Account Name: <strong>" . titlecase($payment->account_name) . "</strong><br><br>";

                                $email_footer = "Regards,<br>";
                                $email_footer .= "$company_short_name Management";

                                //email queue
                                $table_text = "";

                                $parent_id = 0;
                                $reminder_message_id = 0;

                                $result = sendTheEmailToQueue($email, $subject, $title, $company_name, $email_text, $email_salutation,
                                $company_id, $email_footer, $panel_text, $table_text, $parent_id, $reminder_message_id);

                                //dd($email, $subject, $title, $company_name, $email_text, $email_salutation,
                                //$company_id, $email_footer, $panel_text, $table_text, $parent_id, $reminder_message_id);
                                //dd($external_result);
                                //end send email to queue


                            }
                        }
                    }
                }
                //end send account owner email on transaction
            }

            //************************* end update payment *********************************** */

        DB::commit();

        return show_json_success($external_result);

    }

}
