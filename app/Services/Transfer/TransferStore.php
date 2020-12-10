<?php

namespace App\Services\Transfer;

use App\Entities\Transfer;
use Illuminate\Support\Facades\DB;
use App\Entities\DepositAccountSummary;
use App\Entities\DepositAccountHistory;
use App\Services\Payment\PaymentStore;

class TransferStore
{

    public function createItem($request) {

        //dd($attributes);

        $client_deposits_gl_account_type_id = config('constants.gl_account_types.client_deposits');
        //account type texts
        $deposit_account_text = config('constants.account_type_text.deposit_account');
        $loan_account_text = config('constants.account_type_text.loan_account');
        $shares_account_text = config('constants.account_type_text.shares_account');

        DB::beginTransaction();

            $source_account_id = "";
            $destination_account_id = "";
            $source_text = "";
            $destination_text = "";
            $source_account_no = "";
            $destination_account_no = "";
            $amount = "";
            $source_account_text = "";
            $destination_account_text = "";
            $shares = "";

            if ($request->has('source_account')) {
                $source_account_id = $request->source_account;
            }
            if ($request->has('destination_account')) {
                $destination_account_id = $request->destination_account;
            }
            if ($request->has('source_text')) {
                $source_text = $request->source_text;
            }
            if ($request->has('destination_text')) {
                $destination_text = $request->destination_text;
            }
            if ($request->has('amount')) {
                $amount = $request->amount;
            }
            if ($request->has('shares')) {
                $shares = $request->shares;
            }

            //get account names
            if ($source_text) {
                $source_account_text = getAccountNameText($source_text);
            }

            if ($destination_text) {
                $destination_account_text = getAccountNameText($destination_text);
            }

            //get source and destination accounts
            $transfer_data = getTransferSummaryData($request);
            $transfer_data = json_decode($transfer_data);
            //dd($transfer_data);
            $source_account = $transfer_data->source_account;
            $source_company_id = $source_account->company_id;
            $source_account_no = $source_account->account_no;
            $source_account_name = $source_account->account_name;
            $source_account_phone = $source_account->phone;
            $source_account_user_id = $source_account->user_id;
            $source_account_company_user_id = $source_account->company_user_id;
            $destination_account = $transfer_data->destination_account;
            $destination_account_no = $destination_account->account_no;
            $destination_account_name = $destination_account->account_name;
            $destination_account_phone = $destination_account->phone;
            $destination_account_user_id = $destination_account->user_id;
            $destination_account_company_user_id = $destination_account->company_user_id;

            //ensure amount being transferred is not more than source account balance
            $source_amount = $amount;
            $source_amount_fmt = formatCurrency($source_amount);
            $source_account_balance = $source_account->amount;

            if ($source_amount > $source_account_balance) {
                //error, transfer amount cannot be more than account balance
                $source_account_balance_fmt = formatCurrency($source_account_balance);
                $message = "Error. Amount being transferred: $source_amount_fmt ";
                $message .= "cannot be more than source account balance: $source_account_balance_fmt";
                $response["message"] = $message;
                return show_json_error($response);
            }

            //start create new transfer
            try {

                $new_transfer = new Transfer();

                $transfer_comments = "Transfer $source_amount_fmt From  $source_account_text: $source_account_id";
                $transfer_comments .= " - Account Name: ". titlecase($source_account_name);
                $transfer_comments .= " - Account Phone: $source_account_phone,";
                $transfer_comments .= " To  $destination_account_text: $destination_account_id";
                $transfer_comments .= " - Account Name: " . titlecase($destination_account_name);
                $transfer_comments .= " - Account Phone: $destination_account_phone";

                $transfer_attributes['company_id'] = $source_company_id;
                $transfer_attributes['source_company_user_id'] = $source_account_company_user_id;
                $transfer_attributes['destination_company_user_id'] = $destination_account_company_user_id;
                $transfer_attributes['source_account_type'] = $source_text;
                $transfer_attributes['destination_account_type'] = $destination_text;
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
                $transfer_attributes['amount'] = $source_amount;
                $transfer_attributes['comments'] = $transfer_comments;

                //dd($transfer_attributes);

                $result_transfer = $new_transfer->create($transfer_attributes);

                log_this(">>>>>>>>> SNB SUCCESS CREATING TRANSFER :\n\n" . json_encode($result_transfer) . "\n\n\n");
                $response["message"] = $result_transfer;

            } catch(\Exception $e) {

                DB::rollback();
                $message = $e->getMessage();
                log_this(">>>>>>>>> SNB ERROR CREATING TRANSFER :\n\n" . $message . "\n\n\n");
                $response["message"] = $message;
                return show_json_error($response);

            }
            //end create new transfer

            //TRAN REF
            $tran_desc = "Transfer $source_amount_fmt";
            $tran_desc .= " From  $source_account_text: $source_account_id";
            $tran_desc .= " - Account Name: " . titlecase($source_account_name);
            $tran_desc .= " - Account Phone: " . $source_account_phone;
            $tran_desc .= " To  $destination_account_text: $destination_account_id";
            $tran_desc .= " - Account Name: " . titlecase($destination_account_name);
            $tran_desc .= " - Account Phone: $destination_account_phone";

            $tran_ref_txt = "Transfer From Company User ID - $source_account_company_user_id, Account Name - "  . titlecase($source_account_name);

            //start reduce source  account balance
            try {

                if ($source_text == $deposit_account_text) {

                    $source_account_data = DepositAccountSummary::find($source_account_id);
                    $deposit_account_summary_id = $source_account_data->id;
                    $account_no = $source_account_data->account_no;
                    $dep_phone = $source_account_data->phone;
                    $current_balance = $source_account_data->ledger_balance;

                    $new_account_balance = $current_balance - $source_amount;

                    //update deposit account summary, reduce account balance
                    $source_account_update = $source_account_data
                        ->update([
                                    'ledger_balance' => $new_account_balance
                                ]);

                    //start source account deposit acount history record reduction
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
                    $deposit_acct_history_attributes['amount'] = -$source_amount;

                    //dd($deposit_acct_history_attributes);

                    $result = $new_deposit_acct_history->create($deposit_acct_history_attributes);
                    //end add deposit acount history record

                }

            } catch(\Exception $e) {

                DB::rollback();
                $message = 'Error. Could not update source account - ' . $e->getMessage();
                log_this($message . " - ". json_encode($source_account));
                $response["message"] = $message;
                return show_json_error($response);

            }
            //end reduce source  account balance

            //start store gl account entry for reduced deposit in source acount
            try {

                $payment_id = NULL;

                $client_dep_gl_account_entry = createGlAccountEntry($payment_id, $source_amount, $client_deposits_gl_account_type_id,
                                                                    $source_company_id, $source_account_phone, "CR", $tran_ref_txt, $tran_desc, "neg", "pos", "neg");

            } catch(\Exception $e) {

                DB::rollback();
                $message = 'Error. Could not create client_dep_gl_account_entry - ' . $e->getMessage();
                log_this($message);
                //throw new StoreResourceFailedException($message);
                $response["message"] = $message;
                return show_json_error($response);

            }
            //end store gl account entry for reduced deposit in source acount

            //start get main paybill no
            $mpesa_paybill_data = getMainSingleCompanyPaybill($source_company_id);
            $mpesa_paybill_data = json_decode($mpesa_paybill_data);
            $mpesa_paybill_data = $mpesa_paybill_data->data;
            $mpesa_paybill = $mpesa_paybill_data->paybill_number;
            //dd($mpesa_paybill);
            //end get main paybill no

            //if all is ok, create transfer
            if (($destination_text == $deposit_account_text) ||
                ($destination_text == $loan_account_text) ||
                ($destination_text == $shares_account_text)) {
                //dd("dest deposit act", $destination_account);

                //start create new payment deposit item
                try{

                    $paymentStore = new PaymentStore();

                    $payment_id = NULL;

                    //replace amount with new deposit_amount
                    $attributes['amount'] = $source_amount;
                    $attributes['full_name'] = $source_account_name;
                    $attributes['phone_number'] = $source_account_phone;
                    $attributes['paybill_number'] = $mpesa_paybill;
                    $attributes['account_no'] = $destination_account_phone;
                    $attributes['trans_id'] = "";
                    $attributes['src_ip'] = request()->ip();
                    $attributes['payment_id'] = "0";
                    $attributes['payment_name'] = $source_account_name;
                    $attributes['transfer'] = "1";
                    $attributes['source_text'] = $source_text;
                    $attributes['destination_text'] = $destination_text;
                    $attributes['source_account_phone'] = $source_account_phone;
                    $attributes['destination_account_phone'] = $destination_account_phone;
                    $attributes['tran_ref_txt'] = $tran_ref_txt;
                    $attributes['tran_desc'] = $tran_desc;

                    if ($destination_text == $shares_account_text) {
                        $attributes['shares'] = "1";
                    }

                    //dd($attributes);

                    //$response =
                    $paymentStore->createItem($attributes);
                    log_this("\n\n\n************** PAYMENT STORE ************* \n\n"
                    . json_encode($response)
                    . "\n\n*******************************************\n\n");

                } catch(\Exception $e) {

                    DB::rollback();
                    dd($e);
                    $message = 'Error. Could not create payments entry - ' . $e->getMessage();
                    log_this($message);
                    $response["message"] = $message;
                    return show_json_error($response);
                }

            }

            /* if ($destination_text == $loan_account_text) {
                //transfer to destinaton shares account
                dd("dest loan act", $destination_account);
            } */

            /* if ($destination_text == $shares_account_text) {
                //transfer to destinaton shares account
                dd("dest shares act", $destination_account);
            } */

            /* //start check whether member is member of company being added
            if (!$branch_member_data) {

                //get company id
                $company_branch_data = CompanyBranch::find($company_branch_id);
                $company_id = $company_branch_data->company_id;

                $attributes['company_id'] = $company_id;

            } */


        DB::commit();

        return show_json_success($response);

    }

}
