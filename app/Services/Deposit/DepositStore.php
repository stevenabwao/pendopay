<?php

namespace App\Services\Deposit;

use App\Entities\Account;
use App\Entities\DepositAccount;
use App\Entities\DepositAccountSummary;
use App\Entities\DepositAccountHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DepositStore
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

            // set account_no
            if (!$account_no) {
                $account_no = $attributes['phone_number'];
            }
            // dd("dep store == ", $attributes);

            // get settings_company_id
            $settings_company_id = getBarddyCompanyId();

            // get user deposit account
            try {

                $dep_account_data = getUserDepositAccountData("", $account_no);
                $deposit_account_no = $dep_account_data->account_no;
                $deposit_user_id = $dep_account_data->user_id;
                // dd($deposit_user_id, $dep_account_data);

            } catch(\Exception $e) {

                throw new \Exception($e->getMessage());

            }
            // dd("dep_account_data === ", $dep_account_data);

            // get user data from dep acct
            $user_id = $dep_account_data->user_id;
            $account_name = $dep_account_data->account_name;

            // get deposit_account_summary_data
            try {

                $deposit_account_summary_data = DepositAccountSummary::where('account_no', $account_no)->first();
                if ($deposit_account_summary_data) {
                    $ledger_balance = $deposit_account_summary_data->ledger_balance;
                    $dr_count = $deposit_account_summary_data->dr_count;
                }

            } catch(\Exception $e) {

                throw new \Exception($e->getMessage());

            }


            //start edit deposit account summary
            //if  deposit account summary record exists, update it, otherwise create a new entry
            if (!$deposit_account_summary_data) {

                //create new record
                //set attributes
                $deposit_account_summary_attributes['user_id'] = $user_id;
                $deposit_account_summary_attributes['phone'] = $phone;
                $deposit_account_summary_attributes['company_id'] = $settings_company_id;
                $deposit_account_summary_attributes['account_no'] = $account_no;
                $deposit_account_summary_attributes['account_name'] = $account_name;
                $deposit_account_summary_attributes['last_deposit_amount'] = $amount;
                $deposit_account_summary_attributes['last_deposit_date'] = $date;
                $deposit_account_summary_attributes['last_activity_date'] = $date;
                $deposit_account_summary_attributes['ledger_balance'] = $amount;
                $deposit_account_summary_attributes['dr_count'] = "1";

                try {

                    $deposit_account_summary = new DepositAccountSummary();

                    $new_deposit_account_summary_data = $deposit_account_summary->create($deposit_account_summary_attributes);

                 } catch(\Exception $e) {

                    //dd($e);
                    DB::rollback();
                    throw new \Exception($e->getMessage());

                }

            } else {

                //update existing deposit summary account
                $new_ledger_balance = $ledger_balance + $amount;

                try {

                    $deposit_account_summary_update = DepositAccountSummary::where('account_no', $account_no)
                        ->update([
                                    'ledger_balance' => $new_ledger_balance,
                                    'last_deposit_amount' => $amount,
                                    'last_deposit_date' => $date,
                                    'last_activity_date' => $date,
                                    'dr_count' => $dr_count + 1,
                                    'user_id' => $user_id
                                ]);

                 } catch(\Exception $e) {

                    //dd($e);
                    DB::rollback();
                    throw new \Exception($e->getMessage());

                }

            }
            //end edit deposit account summary


            //start create new deposit account history
            try {

                //get deposit account id
                $deposit_account_summary_data = DepositAccountSummary::where('account_no', $account_no)->first();

                if ($deposit_account_summary_data) {

                    $deposit_account_summary_id = $deposit_account_summary_data->id;

                    //create new DepositAccountHistory
                    $deposit_account_history = new DepositAccountHistory();

                    $deposit_account_history_attributes['parent_id'] = $deposit_account_summary_id;
                    $deposit_account_history_attributes['account_no'] = $account_no;
                    $deposit_account_history_attributes['dr_cr_ind'] = 'DR';
                    $deposit_account_history_attributes['amount'] = $amount;
                    $deposit_account_history_attributes['company_id'] = $settings_company_id;
                    $deposit_account_history_attributes['trans_ref_txt'] = $tran_ref_txt;
                    $deposit_account_history_attributes['trans_desc'] = $tran_desc;
                    $deposit_account_history_attributes['mpesa_code'] = $mpesa_code;
                    $deposit_account_history_attributes['created_by_name'] = $payment_name;
                    $deposit_account_history_attributes['updated_by_name'] = $payment_name;
                    $deposit_account_history_attributes['user_id'] = $user_id;

                    $deposit_account_history_data = $deposit_account_history->create($deposit_account_history_attributes);
                    log_this(json_encode($deposit_account_history_data));

                } else {
                    DB::rollback();
                    $message = "Deposit account not found";
                    throw new \Exception($message);
                }

             } catch(\Exception $e) {

                //dd($e);
                DB::rollback();
                throw new \Exception($e->getMessage());

            }

            //end create new deposit account history

        DB::commit();

        return $deposit_account_history_data;

    }

}
