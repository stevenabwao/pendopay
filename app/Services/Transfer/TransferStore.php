<?php

namespace App\Services\Transfer;

use App\Entities\Transfer;
use Illuminate\Support\Facades\DB;
use App\Entities\DepositAccountSummary;
use App\Entities\DepositAccountHistory;
use App\Services\Payment\PaymentMainStore;
use App\Services\Payment\PaymentStore;

class TransferStore
{

    public function createItem($request) {

        $logged_user = getLoggedUser();

        DB::beginTransaction();

            ///////////////////////////////////////
            $destination_account_type = "";
            $destination_account_no = "";
            $transfer_amount = "";

            if ($request->has('destination_account_type')) {
                $destination_account_type = $request->destination_account_type;
            }
            if ($request->has('destination_account_no')) {
                $destination_account_no = $request->destination_account_no;
            }
            if ($request->has('transfer_amount')) {
                $transfer_amount = $request->transfer_amount;
                $transfer_amount_fmt = formatCurrency($transfer_amount);
            }

            //get account names
            $source_account_type = getAccountTypeWalletAccount();
            $source_account_text = getAccountNameText(getAccountTypeWalletAccount());

            $destination_account_text = getAccountNameText($destination_account_type);

            // site settings
            $site_settings = getSiteSettings();
            // dd("site_settings == ", $site_settings);
            $settings_company_id = $site_settings['company_id'];
            $settings_mpesa_paybill_number = $site_settings['paybill_number'];

            // get source account
            try {
                $source_account_data = getUserDepositAccountData("", "", $logged_user->id);
            } catch(\Exception $e) {
                $error_message = $e->getMessage();
                log_this($error_message);
                throw new \exception($error_message);
            }

            // get destination account
            try {
                $destination_account_data = getDestinationAccountData($destination_account_type, $destination_account_no);
            } catch(\Exception $e) {
                $error_message = $e->getMessage();
                log_this($error_message);
                throw new \exception($error_message);
            }
            // dd("HEret == destination_account_data == ", $destination_account_type, $destination_account_no, $destination_account_data);

            //get source and destination accounts
            $source_company_id = $settings_company_id;
            $source_account_no = $source_account_data->account_no;
            $source_account_id = $source_account_data->id;
            $source_account_name = $source_account_data->account_name;
            $source_account_phone = $source_account_data->phone;
            $source_account_user_id = $source_account_data->user_id;
            $source_account_company_user_id = $source_account_data->user_id;

            $destination_account_no = $destination_account_data->account_no;
            $destination_account_id = $destination_account_data->id;
            $destination_account_name = $destination_account_data->account_name;
            $destination_account_phone = $destination_account_data->phone;
            $destination_account_user_id = $destination_account_data->user_id;
            $destination_account_company_user_id = $destination_account_data->user_id;

            //start create new transfer
            try {

                $new_transfer = new Transfer();

                $transfer_comments = "Transfer $transfer_amount_fmt From $source_account_text: $source_account_no";
                $transfer_comments .= " - Account Name: ". titlecase($source_account_name);
                $transfer_comments .= " - Account Phone: $source_account_phone,";
                $transfer_comments .= " To $destination_account_text: $destination_account_no";
                $transfer_comments .= " - Account Name: " . titlecase($destination_account_name);
                $transfer_comments .= " - Account Phone: $destination_account_phone";

                // formulate record attributes
                $transfer_attributes['company_id'] = $source_company_id;
                $transfer_attributes['source_company_user_id'] = $source_account_company_user_id;
                $transfer_attributes['destination_company_user_id'] = $destination_account_company_user_id;
                $transfer_attributes['source_account_type'] = $source_account_text;
                $transfer_attributes['destination_account_type'] = $destination_account_text;
                $transfer_attributes['source_account_name'] = titlecase($source_account_name);
                $transfer_attributes['destination_account_name'] = titlecase($destination_account_name);
                $transfer_attributes['source_account_id'] = $source_account_id;
                $transfer_attributes['destination_account_id'] = $destination_account_id;
                $transfer_attributes['source_user_id'] = $source_account_user_id;
                $transfer_attributes['destination_user_id'] = $destination_account_user_id;
                $transfer_attributes['source_phone'] = $source_account_phone;
                $transfer_attributes['destination_phone'] = $destination_account_phone;
                $transfer_attributes['source_account_no'] = $source_account_no;
                $transfer_attributes['destination_account_no'] = $destination_account_no;
                $transfer_attributes['amount'] = $transfer_amount;
                $transfer_attributes['comments'] = $transfer_comments;


                $result_transfer = $new_transfer->create($transfer_attributes);

                log_this(">>>>>>>>> SUCCESS CREATING TRANSFER :\n\n" . json_encode($result_transfer) . "\n\n\n");
                $response["data"] = $result_transfer;


            } catch(\Exception $e) {

                DB::rollback();
                $message = $e->getMessage();
                log_this(">>>>>>>>> ERROR CREATING TRANSFER :\n\n" . $message . "\n\n\n");
                throw new \Exception($message);

            }
            //end create new transfer

            //TRAN REF
            $tran_desc = "Transfer $transfer_amount_fmt";
            $tran_desc .= " From $source_account_text: $source_account_no";
            $tran_desc .= " - Account Name: " . titlecase($source_account_name);
            $tran_desc .= " - Account Phone: " . $source_account_phone;
            $tran_desc .= " To $destination_account_text: $destination_account_no";
            $tran_desc .= " - Account Name: " . titlecase($destination_account_name);
            $tran_desc .= " - Account Phone: $destination_account_phone";

            $tran_ref_txt = "Transfer From User ID - $source_account_user_id, Account Name - "  . titlecase($source_account_name);

            // start reduce source deposit account balance
            $source_deposit_account_summary_data = getUserDepositAccountSummaryData($logged_user->id);

            try {

                $deposit_account_summary_id = $source_deposit_account_summary_data->id;
                $account_no = $source_deposit_account_summary_data->account_no;
                $dep_phone = $source_deposit_account_summary_data->phone;
                $current_balance = $source_deposit_account_summary_data->ledger_balance;

                $new_account_balance = $current_balance - $transfer_amount;

                // update deposit account summary, reduce account balance
                $deposit_account_summary_update = $source_deposit_account_summary_data
                            ->updatedata($deposit_account_summary_id, ['ledger_balance' => $new_account_balance]);

            } catch(\Exception $e) {

                DB::rollback();
                $message = 'Error. Could not update source_deposit_account_summary_data - ' . $e->getMessage();
                log_this($message . " - ". json_encode($source_deposit_account_summary_data));
                throw new \Exception($message);

            }
            // end reduce source deposit account balance

            // start source account deposit acount history record reduction
            try {

                $new_deposit_acct_history = new DepositAccountHistory();

                $deposit_acct_history_attributes['parent_id'] = $deposit_account_summary_id;
                $deposit_acct_history_attributes['account_no'] = $account_no;
                $deposit_acct_history_attributes['phone'] = $dep_phone;
                $deposit_acct_history_attributes['dr_cr_ind'] = 'CR';
                $deposit_acct_history_attributes['company_id'] = $source_company_id;
                $deposit_acct_history_attributes['trans_ref_txt'] = $tran_ref_txt;
                $deposit_acct_history_attributes['trans_desc'] = $tran_desc;
                $deposit_acct_history_attributes['company_user_id'] = $source_account_company_user_id;
                $deposit_acct_history_attributes['user_id'] = $source_account_user_id;
                $deposit_acct_history_attributes['amount'] = -$transfer_amount;

                $result = $new_deposit_acct_history->create($deposit_acct_history_attributes);
                // end add deposit acount history record

            } catch(\Exception $e) {

                DB::rollback();
                $message = 'Error. Could not update source deposit account - ' . $e->getMessage();
                log_this($message . " - ". json_encode($source_account_data));
                throw new \Exception($message);

            }
            // end source account deposit acount history record reduction

            // start store gl account entry for reduced deposit in source acount
            try {

                $payment_id = NULL;

                $client_dep_gl_account_entry = createGlAccountEntry($payment_id, $transfer_amount, getGlAccountTypeClientDeposits(),
                                                                    $source_company_id, $source_account_phone, "CR", $tran_ref_txt,
                                                                    $tran_desc, "neg", "pos", "neg");

            } catch(\Exception $e) {

                DB::rollback();
                $message = 'Error. Could not create client_dep_gl_account_entry - ' . $e->getMessage();
                log_this($message);
                throw new \Exception($message);

            }

            //if all is ok, create transfer
            //start create new payment deposit item
            try{

                $paymentMainStore = new PaymentMainStore();

                $payment_id = NULL;

                //replace amount with new deposit_amount
                $attributes['amount'] = $transfer_amount;
                $attributes['full_name'] = $source_account_name;
                $attributes['phone_number'] = $source_account_phone;
                // $attributes['paybill_number'] = $settings_mpesa_paybill_number;
                $attributes['account_no'] = $destination_account_phone;
                $attributes['trans_id'] = "";
                $attributes['src_ip'] = request()->ip();
                $attributes['payment_id'] = "0";
                $attributes['payment_method_id'] = getPaymentMethodTransfer();
                $attributes['payment_name'] = $source_account_name;
                $attributes['transfer'] = "1";
                $attributes['source_text'] = $source_account_text;
                $attributes['destination_text'] = $destination_account_text;
                $attributes['source_account_phone'] = $source_account_phone;
                $attributes['destination_account_phone'] = $destination_account_phone;
                $attributes['tran_ref_txt'] = $tran_ref_txt;
                $attributes['tran_desc'] = $tran_desc;

                // dd($attributes);

                $payment_main_response = $paymentMainStore->createItem($attributes);
                log_this("\n\n\n************** PAYMENT STORE ************* \n\n" . json_encode($payment_main_response)
                            . "\n\n*******************************************\n\n");

            } catch(\Exception $e) {

                DB::rollback();
                // dd($e);
                $message = 'Error. Could not create payments entry - ' . $e->getMessage();
                log_this($message);
                throw new \Exception($message);
            }


            ////////////////////////////
            // create main payment first
            // start set attributes
            $attributes['amount'] = $transfer_amount;
            $attributes['full_name'] = $source_account_name;
            $attributes['phone_number'] = $source_account_phone;
            $attributes['account_no'] = $destination_account_phone;
            $attributes['trans_id'] = "";
            $attributes['src_ip'] = request()->ip();
            $attributes['payment_id'] = "0";
            $attributes['payment_method_id'] = getPaymentMethodTransfer();
            $attributes['payment_name'] = $source_account_name;
            $attributes['transfer'] = "1";
            $attributes['source_account_text'] = $source_account_text;
            $attributes['destination_account_type'] = $destination_account_type;
            $attributes['destination_account_text'] = $destination_account_text;
            $attributes['source_account_phone'] = $source_account_phone;
            $attributes['source_account_no'] = $source_account_no;
            $attributes['destination_account_phone'] = $destination_account_phone;
            $attributes['destination_account_no'] = $destination_account_no;
            $attributes['tran_ref_txt'] = $tran_ref_txt;
            $attributes['tran_desc'] = $tran_desc;
            // end set attributes

            try {
                $paymentMainStore = new PaymentMainStore();

                $payment_main_result = $paymentMainStore->createItem($attributes);
                $payment_main_result = json_decode($payment_main_result);
                log_this("\n\n\n************** PAYMENT MAIN STORE ************* \n\n" . json_encode($payment_main_result)
                            . "\n\n*******************************************\n\n");
            } catch(\Exception $e) {
                DB::rollback();
                log_this($e->getMessage());
                // dd($e);
                return showCompoundMessage(422, $e->getMessage());
            }

            $payment_main_result_message = $payment_main_result->message;
            $new_payment_main_result_message = $payment_main_result_message->message;
            // dd($new_payment_main_result_message->id);

            //start create payment data
            try {
                //create item
                $paymentStore = new PaymentStore();

                $payment_result = $paymentStore->createItem($attributes, $new_payment_main_result_message);
                $payment_result = json_decode($payment_result);
                log_this($payment_result);
                $response['message'] = "Payment created";

                log_this("\n\n\n************** PAYMENT STORE ************* \n\n" . json_encode($payment_result)
                            . "\n\n*******************************************\n\n");
            } catch(\Exception $e) {
                DB::rollback();
                dd($e);
                $show_message = $e->getMessage();
                // $show_message = $message . ' - ' . $e;
                log_this($show_message);
                throw new \Exception($show_message);
            }
            ////////////////////////////


        DB::commit();

        return show_json_success($response);

    }

}
