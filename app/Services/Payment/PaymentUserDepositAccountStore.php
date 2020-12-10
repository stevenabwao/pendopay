<?php

namespace App\Services\Payment;

use App\Entities\Payment;
use App\Entities\PaymentDeposit;
use App\Services\Payment\PaymentDepositStore;
use App\Services\Deposit\DepositStore;
use Illuminate\Support\Facades\DB;

class PaymentUserDepositAccountStore
{

    public function createItem($attributes, $new_payment) {

        $mpesa_payment_id = getPaymentMethodMpesa();
        $client_deposits_gl_account_type_id = getGlAccountTypeClientDeposits();

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
        if (array_key_exists('deposit_amount', $attributes)) {
            $deposit_amount = $attributes['deposit_amount'];
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
        if (!$payment_method_id) {
            $payment_method_id = getPaymentMethodMpesa();
        }

        // get settings_company_id
        $site_settings = getSiteSettings();
        $settings_company_id = $site_settings['company_id'];
        $settings_company_name = $site_settings['company_name_title'];

        // read new_payment object
        $payment_id = $new_payment->id;

        // set account_no
        if (!$account_no) {
            $account_no = $attributes['phone_number'];
        }

        // convert account no to valid phone, throw error ir wrong entry is encountered
        try {
            $account_no = getDatabasePhoneNumber($attributes['phone_number']);
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        //start transaction
        DB::beginTransaction();

            $user_id = NULL;
            $user_email = "";
            $user_full_names = "";
            $user_first_name = "";
            $response = [];

            // get data
            if ($account_no) {

                // get user data
                try {

                    $user_data = getUserData($account_no);
                    // dd("user_data == ", $user_data);
                    $user_id = $user_data->id;
                    $user_email = $user_data->email;
                    $user_full_names = $user_data->full_name;
                    $user_first_name = $user_data->first_name;

                } catch(\Exception $e) {

                    throw new \Exception($e->getMessage());

                }

                // get user deposit account
                try {

                    $user_deposit_account_data = getUserDepositAccountData("", "", $user_id);
                    $deposit_account_no = $user_deposit_account_data->account_no;
                    $deposit_user_id = $user_id;
                    // dd($deposit_user_id, $user_deposit_account_data);

                } catch(\Exception $e) {

                    throw new \Exception($e->getMessage());

                }

                // proceed if user exists
                if ($user_deposit_account_data) {

                    //end check if account_no exists
                    if ($user_deposit_account_data) {

                        if ($deposit_amount > 0) {

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
                                $attributes['amount'] = $deposit_amount;
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

                                $tran_ref_txt = "mpesa_code - $mpesa_code - full_name - $full_name - payment_id - $payment_id";
                                $tran_desc = "Deposit - user id - $deposit_user_id - Deposit account number - $deposit_account_no";

                                $client_dep_gl_account_entry = createGlAccountEntry($payment_id, $deposit_amount, $client_deposits_gl_account_type_id,
                                                                                    $settings_company_id, $phone_number, "DR", $tran_ref_txt, $tran_desc, "neg", "neg");

                                log_this(json_encode($client_dep_gl_account_entry));

                            } catch(\Exception $e) {

                                DB::rollback();
                                // dd($e);
                                $show_message = trans('general.couldnotcreateclientdepositglentry');
                                log_this($show_message);
                                throw new \Exception($show_message);

                            }

                        }

                    }

                }

            }

            // send user email/ sms
            // if payment was made
            if ($deposit_amount > 0) {

                $deposit_amount_fmt = formatCurrency($deposit_amount);

                // start generate sms message
                // create sms replacement array
                $sms_replacement_array = array();
                $sms_replacement_array[] = $full_name;
                $sms_replacement_array[] = $deposit_amount_fmt;
                $sms_replacement_array[] = $settings_company_name;
                $sms_replacement_array[] = $account_no;
                $sms_replacement_array[] = $settings_company_name;

                // generate sms message
                $sms_message = generateTemplateMessage(getMediaTypeSms(), getSiteFunctionPaymentUserDepositAccountSuccess(), $sms_replacement_array);
                // end generate sms message

                // dd($sms_message);

                // send sms
                /* $result = createSmsOutbox($sms_message, $phone_number, getCompanySmsType(), $settings_company_id);
                log_this(json_encode($result)); */

            }
            // dd("end", $deposit_amount);

            // send email
            if ($user_email) {

                $email_text = "";
                $panel_text = "";

                //start send email to queue
                if ($deposit_amount > 0) {
                    $subject = 'Dear ' . $user_first_name . ', Successful deposit to your wallet at ' . $settings_company_name;
                }

                $title = $subject;

                $email_salutation = "Dear " . $user_first_name . ",<br><br>";

                if ($deposit_amount > 0) {

                    $email_text = "Deposit of <strong>" . formatCurrency($deposit_amount) . "</strong> has been made to your wallet at " . $settings_company_name;
                    if ($paybill_number) {
                        $email_text .= " via paybill no. $paybill_number.<br><br>";
                    }
                    $email_text .= "Deposit details are as follows: <br><br>";

                }

                $panel_text = "Sender Full Name: <strong>" . titlecase($full_name) . "</strong><br>";
                if ($phone_number) {
                    $panel_text .= "Sender Phone: <strong>" . $phone_number . "</strong><br>";
                }
                $panel_text .= "Amount: <strong>" . formatCurrency($deposit_amount) . "</strong><br>";

                $email_footer = "Regards,<br>";
                $email_footer .= "$settings_company_name Management";

                //email queue
                $table_text = "";

                $parent_id = 0;
                $reminder_message_id = 0;

                $result = sendTheEmailToQueue($user_email, $subject, $title, $settings_company_name, $email_text, $email_salutation,
                                              $settings_company_id, $email_footer, $panel_text, $table_text, $parent_id, $reminder_message_id);
                //end send email to queue

            }

        DB::commit();

        $show_message = trans('general.successfulwalletdeposit');
        $response['message'] = $show_message;
        return show_success_response($response);

    }

}
