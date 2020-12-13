<?php

namespace App\Services\Transaction;

use App\Entities\Account;
use App\Entities\DepositAccount;
use App\Entities\Transaction;
use App\Entities\TransactionAccountSummary;
use App\Entities\TransactionAccountHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionStore
{

    public function createItem($attributes) {

        //dd($attributes);

        //current date and time
        $date = getUpdatedDate();

        DB::beginTransaction();

            $phone = "";
            $amount = "";
            $mpesa_code = "";
            $payment_name = "";
            $tran_ref_txt = "";
            $tran_desc = "";
            $ledger_balance = 0;

            //get current deposit account
            $account_no = $attributes['account_no'];
            $amount = $attributes['amount'];

            if (array_key_exists('phone_number', $attributes)) {
                $phone = $attributes['phone_number'];
            }
            if (array_key_exists('amount', $attributes)) {
                $amount = $attributes['amount'];
            }
            if (array_key_exists('trans_id', $attributes)) {
                $mpesa_code = $attributes['trans_id'];
            }
            if (array_key_exists('payment_name', $attributes)) {
                $payment_name = $attributes['payment_name'];
            }
            if (array_key_exists('payment_id', $attributes)) {
                $payment_id = $attributes['payment_id'];
            }
            if (array_key_exists('tran_ref_txt', $attributes)) {
                $tran_ref_txt = $attributes['tran_ref_txt'];
            }
            if (array_key_exists('tran_desc', $attributes)) {
                $tran_desc = $attributes['tran_desc'];
            }

            // get settings_company_id
            $settings_company_id = getBarddyCompanyId();

            // get transaction account
            try {

                $trans_account_data = getTransactionAccountData($account_no);

            } catch(\Exception $e) {

                throw new \Exception($e->getMessage());

            }

            // if transaction account does not exist, throw error
            if (!$trans_account_data) {
                $error_message = trans('general.destinationaccountnotfound');
                throw new \Exception($error_message);
            }

            // get transaction_account_summary_data
            try {

                $transaction_account_summary_data = TransactionAccountSummary::where('account_no', $account_no)->first();
                if ($transaction_account_summary_data) {
                    $ledger_balance = $transaction_account_summary_data->ledger_balance;
                    $dr_count = $transaction_account_summary_data->dr_count;
                }

            } catch(\Exception $e) {

                throw new \Exception($e->getMessage());

            }

            //start edit transaction account summary
            //if  transaction account summary record exists, update it, otherwise create a new entry
            if (!$transaction_account_summary_data) {

                // create new record
                // set attributes
                $transaction_account_summary_attributes['parent_id'] = $trans_account_data->id;
                // $transaction_account_summary_attributes['phone'] = $phone;
                $transaction_account_summary_attributes['company_id'] = $settings_company_id;
                $transaction_account_summary_attributes['account_no'] = $account_no;
                $transaction_account_summary_attributes['account_name'] = $trans_account_data->account_name;
                $transaction_account_summary_attributes['last_deposit_amount'] = $amount;
                $transaction_account_summary_attributes['last_deposit_date'] = $date;
                $transaction_account_summary_attributes['last_activity_date'] = $date;
                $transaction_account_summary_attributes['ledger_balance'] = $amount;
                $transaction_account_summary_attributes['dr_count'] = "1";

                try {

                    $transaction_account_summary = new TransactionAccountSummary();

                    $new_transaction_account_summary_data = $transaction_account_summary->create($transaction_account_summary_attributes);

                    log_this("created new_transaction_account_summary_data " . json_encode($new_transaction_account_summary_data));

                 } catch(\Exception $e) {

                    //dd($e);
                    DB::rollback();
                    log_this($e->getMessage());
                    throw new \Exception($e->getMessage());

                }

            } else {

                // update existing transaction summary account
                $new_ledger_balance = $ledger_balance + $amount;

                try {

                    $transaction_account_summary_update = TransactionAccountSummary::where('account_no', $account_no)
                        ->update([
                                    'ledger_balance' => $new_ledger_balance,
                                    'last_deposit_amount' => $amount,
                                    'last_deposit_date' => $date,
                                    'last_activity_date' => $date,
                                    'dr_count' => $dr_count + 1
                                ]);

                 } catch(\Exception $e) {

                    //dd($e);
                    DB::rollback();
                    log_this($e->getMessage());
                    throw new \Exception($e->getMessage());

                }

            }
            // end edit transaction account summary

            // start create new transaction account history
            try {

                //get transaction account id
                $transaction_account_summary_data = TransactionAccountSummary::where('account_no', $account_no)->first();

                if ($transaction_account_summary_data) {

                    $transaction_account_summary_id = $transaction_account_summary_data->id;

                    //create new TransactionAccountHistory
                    $transaction_account_history = new TransactionAccountHistory();

                    $transaction_account_history_attributes['parent_id'] = $transaction_account_summary_id;
                    $transaction_account_history_attributes['account_no'] = $account_no;
                    $transaction_account_history_attributes['dr_cr_ind'] = 'DR';
                    $transaction_account_history_attributes['amount'] = $amount;
                    $transaction_account_history_attributes['company_id'] = $settings_company_id;
                    $transaction_account_history_attributes['trans_ref_txt'] = $tran_ref_txt;
                    $transaction_account_history_attributes['trans_desc'] = $tran_desc;
                    $transaction_account_history_attributes['mpesa_code'] = $mpesa_code;
                    $transaction_account_history_attributes['created_by_name'] = $payment_name;
                    $transaction_account_history_attributes['updated_by_name'] = $payment_name;
                    // $transaction_account_history_attributes['user_id'] = $user_id;

                    $transaction_account_history_data = $transaction_account_history->create($transaction_account_history_attributes);
                    log_this(json_encode($transaction_account_history_data));

                } else {
                    DB::rollback();
                    $message = trans('general.destinationaccountnotfound');
                    log_this($message);
                    throw new \Exception($message);
                }

             } catch(\Exception $e) {

                //dd($e);
                DB::rollback();
                log_this($e->getMessage());
                throw new \Exception($e->getMessage());

            }
            // end create new transaction account history

            // start reduce transaction balance
            $transaction_data = $trans_account_data->transaction;
            $transaction_balance = $transaction_data->transaction_balance;
            $transaction_amount = $transaction_data->transaction_amount;
            $transaction_amount_paid = $transaction_data->transaction_amount_paid;

            // get new balance
            if (!$transaction_balance) {
                $transaction_balance = $transaction_amount;
            }
            $new_transaction_balance = $transaction_balance - $amount;
            $new_transaction_amount_paid = $transaction_amount_paid + $amount;

            try {

                $transaction_update = Transaction::find($trans_account_data->transaction_id)
                    ->update([
                                'transaction_balance' => $new_transaction_balance,
                                'transaction_amount_paid' => $new_transaction_amount_paid
                            ]);

             } catch(\Exception $e) {

                //dd($e);
                DB::rollback();
                log_this($e->getMessage());
                throw new \Exception($e->getMessage());

            }
            // end reduce transaction balance

        DB::commit();

        return $transaction_account_history_data;

    }

}
