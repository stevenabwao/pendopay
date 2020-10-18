<?php

namespace App\Services\Shares;

use App\Entities\Account;
use App\Entities\Company;
use App\Entities\DepositAccount;
use App\Entities\SharesAccount;
use App\Entities\SharesAccountSummary;
use App\Entities\SharesAccountHistory;
use App\User;
use Carbon\Carbon; 
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;

class SharesStore
{

    use Helpers; 

    public function createItem($attributes) {

        //dd($attributes);

        //current date and time
        $date = Carbon::now();
        //$date = getLocalDate($date);
        //$date = $date->toDateTimeString();
        $shares_product_id = config('constants.account_settings.shares_account_product_id');

        DB::beginTransaction();

            $company_user_id = "";
            $mpesa_code = "";
            $payment_name = "";
            $payment_id = "";
            $ledger_balance = 0;
            $transfer = "";
            $transfer_tran_ref_txt = "";
            $transfer_tran_desc = "";

            //get current deposit account
            if (array_key_exists('account_no', $attributes)) {
                $account_no = $attributes['account_no'];
            }
            if (array_key_exists('amount', $attributes)) {
                $amount = $attributes['amount'];
            }
            if (array_key_exists('company_user_id', $attributes)) {
                $company_user_id = $attributes['company_user_id'];
            }
            if (array_key_exists('mpesa_code', $attributes)) {
                $mpesa_code = $attributes['mpesa_code'];
            }
            if (array_key_exists('payment_name', $attributes)) {
                $payment_name = $attributes['payment_name'];
            }
            if (array_key_exists('payment_id', $attributes)) {
                $payment_id = $attributes['payment_id'];
            }
            if (array_key_exists('transfer', $attributes)) {
                $transfer = $attributes['transfer'];
            }
            if (array_key_exists('tran_ref_txt', $attributes)) {
                $transfer_tran_ref_txt = $attributes['tran_ref_txt'];
            }
            if (array_key_exists('tran_desc', $attributes)) {
                $transfer_tran_desc = $attributes['tran_desc'];
            }

            //get the ref account no
            $ref_account_data = DepositAccount::where('account_no', $account_no)->first();
            $ref_account_no = $ref_account_data->ref_account_no;

            //dd($account_no, $ref_account_no, $ref_account_data);

            //start check if account_no exists
            $account_summary_data = Account::where('account_no', $ref_account_no)->first();

            //dd($account_summary_data);

            $phone = "";
            $company_id = $account_summary_data->company_id;
            $user_id = $account_summary_data->user_id;
            $product_id = $account_summary_data->product_id;
            $company_user_id = $account_summary_data->company_user_id;
            $account_id = $account_summary_data->account_id;
            $account_name = $account_summary_data->account_name;

            if ($account_summary_data->user) {
                $phone = $account_summary_data->user->phone;
            } 

            //get the user phone
            //$user_data = User::find($user_id);
            //$phone = $user_data->phone;

            $shares_account_data = SharesAccount::where('phone', $phone)->first();
            if (!$shares_account_data) {
                
                //start create new shares account
                try {

                    $shares_account = new SharesAccount();

                    //generate shares account number
                    $shares_account_no = generate_account_number($company_id, '', $user_id,  $shares_product_id);

                    //get account details
                    $savings_account_no = $account_summary_data->account_no;
                    $savings_account_id = $account_summary_data->id;
                    $account_name = $account_summary_data->account_name;

                    $shares_acct_attributes['ref_account_id'] = $savings_account_id;
                    $shares_acct_attributes['account_no'] = $shares_account_no;
                    $shares_acct_attributes['phone'] = $phone;
                    $shares_acct_attributes['ref_account_no'] = $savings_account_no;
                    $shares_acct_attributes['account_name'] = $account_name;
                    $shares_acct_attributes['product_id'] = $shares_product_id;
                    $shares_acct_attributes['opened_at'] = $date;
                    $shares_acct_attributes['available_at'] = $date;
                    $shares_acct_attributes['company_id'] = $company_id;
                    $shares_acct_attributes['user_id'] = $user_id;
                    $shares_acct_attributes['company_user_id'] = $company_user_id;

                    $shares_account_data = $shares_account::create($shares_acct_attributes);

                } catch(Exception $e) {

                    DB::rollback();
                    log_this($e->getMessage());
                    $message = "Could not create user shares account";
                    throw new StoreResourceFailedException($message);

                }
                //end create new shares account

            }


            //start edit deposit account summary
            $shares_account_summary_data = SharesAccountSummary::where('phone', $phone)
                                                                ->where('company_id', $company_id) 
                                                                ->first();
            if ($shares_account_summary_data) {
                $ledger_balance = $shares_account_summary_data->ledger_balance;
                $dr_count = $shares_account_summary_data->dr_count;
            }

            //if  deposit account summary record exists, update it, otherwise create a new entry
            if (!$shares_account_summary_data) {

                //create new record
                //get next account number
                $shares_account_no = generate_account_number($company_id, '', $user_id,  $shares_product_id);

                //set attributes
                $shares_account_summary_attributes['company_user_id'] = $company_user_id;
                $shares_account_summary_attributes['user_id'] = $user_id;
                $shares_account_summary_attributes['phone'] = $phone;
                $shares_account_summary_attributes['company_id'] = $company_id;
                $shares_account_summary_attributes['account_id'] = $shares_account_data->id;
                $shares_account_summary_attributes['account_no'] = $shares_account_data->account_no;
                $shares_account_summary_attributes['account_name'] = $shares_account_data->account_name;
                $shares_account_summary_attributes['last_deposit_amount'] = $amount;
                $shares_account_summary_attributes['last_deposit_date'] = $date;
                $shares_account_summary_attributes['last_activity_date'] = $date;
                $shares_account_summary_attributes['ledger_balance'] = $amount;
                $shares_account_summary_attributes['dr_count'] = "1";

                try {

                    $shares_account_summary = new SharesAccountSummary();
                    $new_shares_account_summary_data = $shares_account_summary->create($shares_account_summary_attributes);

                 } catch(\Exception $e) {

                    //dd($e);
                    DB::rollback();
                    log_this($e->getMessage());
                    throw new StoreResourceFailedException($e->getMessage());

                }

            } else {

                //update existing deposit summary account
                $new_ledger_balance = $ledger_balance + $amount;

                try {

                    $shares_account_summary_update = SharesAccountSummary::where('phone', $phone)
                            ->where('company_id', $company_id) 
                            ->update([
                                    'ledger_balance' => $new_ledger_balance,
                                    'last_deposit_amount' => $amount,
                                    'last_deposit_date' => $date,
                                    'last_activity_date' => $date,
                                    'dr_count' => $dr_count + 1,
                                    'company_user_id' => $company_user_id,
                                    'user_id' => $user_id,
                                ]);

                 } catch(\Exception $e) {

                    //dd($e);
                    DB::rollback();
                    //dd($e);
                    throw new StoreResourceFailedException($e->getMessage());

                }

            }

            //end edit deposit account summary


            //start create new deposit account history

            try {

                //get deposit account id
                $shares_account_summary_data = SharesAccountSummary::where('phone', $phone)
                                                                    ->where('company_id', $company_id) 
                                                                    ->first();

                //dd($shares_account_summary_data); 

                if ($shares_account_summary_data) {

                    $shares_account_summary_id = $shares_account_summary_data->id;

                    //create new SharesAccountHistory
                    $shares_account_history = new SharesAccountHistory();

                    if ($transfer) {
                        $trans_ref_txt = $transfer_tran_ref_txt;
                        $tran_desc = $transfer_tran_desc;
                    } else {
                        $trans_ref_txt = "payment_id - $payment_id, - payment_name - $payment_name, - mpesa_code - $mpesa_code";
                        $tran_desc = "Shares Deposit - company user - $company_user_id";
                    }

                    $shares_account_history_attributes['parent_id'] = $shares_account_summary_id;
                    $shares_account_history_attributes['account_no'] = $shares_account_data->account_no;
                    $shares_account_history_attributes['dr_cr_ind'] = 'DR';
                    $shares_account_history_attributes['amount'] = $amount;
                    $shares_account_history_attributes['phone'] = $phone;
                    $shares_account_history_attributes['company_id'] = $company_id;
                    $shares_account_history_attributes['trans_ref_txt'] = $trans_ref_txt;
                    $shares_account_history_attributes['trans_desc'] = $tran_desc;
                    $shares_account_history_attributes['created_by_name'] = $payment_name;
                    $shares_account_history_attributes['updated_by_name'] = $payment_name;
                    $shares_account_history_attributes['company_user_id'] = $company_user_id;
                    $shares_account_history_attributes['mpesa_code'] = $mpesa_code;
                    $shares_account_history_attributes['user_id'] = $user_id;

                    $shares_account_history_data = $shares_account_history->create($shares_account_history_attributes);

                    //dd($shares_account_history_data);

                } else {
                    DB::rollback();
                    $message = "Deposit account not found";
                    throw new StoreResourceFailedException($message);
                }

             } catch(\Exception $e) { 

                //dd($e);
                DB::rollback();
                //dd($e);
                throw new StoreResourceFailedException($e->getMessage());

            }

            //end create new deposit account history

        DB::commit();

        return $shares_account_history_data;

    }

}
