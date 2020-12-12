<?php

namespace App\Services\Payment;

use App\Entities\Payment;
use App\Entities\PaymentDeposit;
use App\Services\Payment\PaymentDepositStore;
use App\Services\Deposit\DepositStore;
use Illuminate\Support\Facades\DB;

class PaymentUserTransferStore
{

    public function createItem($attributes, $new_payment) {

        // dd("PaymentUserTransferStore attributes == ", $attributes);
        $mpesa_payment_id = getPaymentMethodMpesa();
        $client_deposits_gl_account_type_id = getGlAccountTypeClientDeposits();

        // logged in user
        $logged_user = getLoggedUser();

        ///////////////////////////////////////
        $source_account_text = "";
        $destination_account_text = "";
        $source_account_phone = "";
        $source_account_no = "";
        $destination_account_phone = "";
        $destination_account_type = "";
        $destination_account_no = "";
        $paybill_number = "";
        $payment_method_id = "";
        $payment_id = "";

        if (array_key_exists('amount', $attributes)) {
            $amount = $attributes['amount'];
        }
        if (array_key_exists('full_name', $attributes)) {
            $full_name = $attributes['full_name'];
        }
        if (array_key_exists('phone_number', $attributes)) {
            $phone_number = $attributes['phone_number'];
        }
        if (array_key_exists('paybill_number', $attributes)) {
            $paybill_number = $attributes['paybill_number'];
        }
        if (array_key_exists('account_no', $attributes)) {
            $account_no = $attributes['account_no'];
        }
        if (array_key_exists('src_ip', $attributes)) {
            $src_ip = $attributes['src_ip'];
        }
        if (array_key_exists('source_account_text', $attributes)) {
            $source_account_text = $attributes['source_account_text'];
        }
        if (array_key_exists('destination_account_text', $attributes)) {
            $destination_account_text = $attributes['destination_account_text'];
        }
        if (array_key_exists('source_account_phone', $attributes)) {
            $source_account_phone = $attributes['source_account_phone'];
        }
        if (array_key_exists('source_account_no', $attributes)) {
            $source_account_no = $attributes['source_account_no'];
        }
        if (array_key_exists('destination_account_phone', $attributes)) {
            $destination_account_phone = $attributes['destination_account_phone'];
        }
        if (array_key_exists('destination_account_no', $attributes)) {
            $destination_account_no = $attributes['destination_account_no'];
        }
        if (array_key_exists('destination_account_type', $attributes)) {
            $destination_account_type = $attributes['destination_account_type'];
        }
        if (array_key_exists('tran_ref_txt', $attributes)) {
            $tran_ref_txt = $attributes['tran_ref_txt'];
        }
        if (array_key_exists('tran_desc', $attributes)) {
            $tran_desc = $attributes['tran_desc'];
        }
        if (array_key_exists('payment_method_id', $attributes)) {
            $payment_method_id = $attributes['payment_method_id'];
        }
        // get payment id
        $payment_id = $new_payment->id;

        // get settings_company_id
        $site_settings = getSiteSettings();
        // dd($site_settings);
        $settings_company_id = $site_settings['company_id'];
        $settings_company_name = $site_settings['company_name_title'];
        $settings_company_website = $site_settings['contact_website'];

        //get account names
        if ($source_account_text) {
            $source_account_text = $source_account_text;
        }

        if ($destination_account_text) {
            $destination_account_text = $destination_account_text;
        }

        // get destination account
        try {
            $destination_account_data = getDestinationAccountData($destination_account_type, $destination_account_no);
        } catch(\Exception $e) {
            $error_message = $e->getMessage();
            log_this($error_message);
            throw new \exception($error_message);
        }

        if (!$destination_account_data) {
            $error_message = trans('general.destinationaccountnotfound');
            log_this($error_message);
            throw new \exception($error_message);
        }

        //start transaction
        DB::beginTransaction();

            $user_id = NULL;
            $user_email = "";
            $user_full_names = "";
            $user_first_name = "";
            $response = [];

            //////////////////////////
            try{

                $paymentDepositStore = new PaymentDepositStore();

                //replace amount with new amount
                $payment_deposit_attributes['amount'] = $amount;
                $payment_deposit_attributes['account_no'] = $account_no;
                $payment_deposit_attributes['phone'] = $phone_number;
                $payment_deposit_attributes['phone_number'] = $phone_number;
                $payment_deposit_attributes['mpesa_code'] = "";
                $payment_deposit_attributes['payment_id'] = $payment_id;
                $payment_deposit_attributes['payment_method_id'] = $payment_method_id;
                $payment_deposit_attributes['full_name'] = $full_name;
                $payment_deposit_attributes['transfer'] = "1";
                $payment_deposit_attributes['tran_ref_txt'] = $tran_ref_txt;
                $payment_deposit_attributes['tran_desc'] = $tran_desc;
                // dd($payment_deposit_attributes);

                $payment_deposit_result = $paymentDepositStore->createItem($payment_id, $payment_deposit_attributes);
                log_this("\n\n\n************** PAYMENT STORE ************* \n\n" . json_encode($payment_deposit_result)
                    . "\n\n*******************************************\n\n");

            } catch(\Exception $e) {
                DB::rollback();
                //dd($e);
                $error_message = $e->getMessage();
                throw new \Exception($error_message);
            }
            //end create new payment deposit item

            // get destination account summary
            $dest_user_id = $destination_account_data->user_id;

            try {
                $destination_deposit_account_summary_data = getUserDepositAccountSummaryData($dest_user_id);
                // dd("destination_deposit_account_summary_data == ", $destination_deposit_account_summary_data);
            } catch(\Exception $e) {
                DB::rollback();
                //dd($e);
                $error_message = $e->getMessage();
                throw new \Exception($error_message);
            }
            //////////////////////////

            // send user email/ sms
            $amount_fmt = formatCurrency($amount);

            // start generate sms message
            // create sms replacement array
            $sms_replacement_array = array();
            $sms_replacement_array[] = $full_name;
            $sms_replacement_array[] = $amount_fmt;
            $sms_replacement_array[] = $settings_company_name;
            $sms_replacement_array[] = $account_no;
            $sms_replacement_array[] = $settings_company_name;

            // generate and send sms message
            try {

                $sms_message = generateTemplateMessage(getMediaTypeSms(),
                                getSiteFunctionPaymentSenderTransferSuccess(), $sms_replacement_array);

                // dd($sms_message);

                // send sms
                /* $result = createSmsOutbox($sms_message, $phone_number, getCompanySmsType(), $settings_company_id);
                log_this(json_encode($result)); */

            } catch(\Exception $e) {
                DB::rollback();
                //dd($e);
                $error_message = $e->getMessage();
                throw new \Exception($error_message);
            }
            // end generate and send sms message

            // send email
            if ($user_email) {

                $email_text = "";
                $panel_text = "";

                //start send email to queue
                if ($amount > 0) {
                    $subject = 'Dear ' . $user_first_name . ', Successful deposit to your wallet at ' . $settings_company_name;
                }

                $title = $subject;

                $email_salutation = "Dear " . $user_first_name . ",<br><br>";

                if ($amount > 0) {

                    $email_text = "Deposit of <strong>" . formatCurrency($amount) . "</strong> has been made to your wallet at " . $settings_company_name;
                    if ($paybill_number) {
                        $email_text .= " via paybill no. $paybill_number.<br><br>";
                    }
                    $email_text .= "Deposit details are as follows: <br><br>";

                }

                $panel_text = "Sender Full Name: <strong>" . titlecase($full_name) . "</strong><br>";
                if ($phone_number) {
                    $panel_text .= "Sender Phone: <strong>" . $phone_number . "</strong><br>";
                }
                $panel_text .= "Amount: <strong>" . formatCurrency($amount) . "</strong><br>";

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

        $show_message = trans('general.successfultransfer', ['amount' => $amount]);
        $response['message'] = $show_message;
        return show_success_response($response);

    }

}
