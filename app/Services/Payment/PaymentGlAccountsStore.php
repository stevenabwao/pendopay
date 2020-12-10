<?php

namespace App\Services\Payment;

use App\Entities\GlAccount;
use App\Entities\GlAccountHistory;
use App\Entities\GlAccountSummary;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentGlAccountsStore
{

    public function createItem($payment_id, $attributes) {

        // dd($attributes);

        DB::enableQueryLog();

        //current date and time
        $date = getCurrentDate(1);

        //get sent details
        $company_id = "";
        $amount = "";
        $gl_account_type_id = "";
        $payment_id = "";
        $phone = "";
        $dr_cr_ind = "";
        $tran_ref_txt = "";
        $tran_desc = "";
        $summ_sign = "";
        $hist_sign = "";
        $summ_action = "";
        $hist_action = "";
        $system_id = "1";
        $system_name = "System";

        if (array_key_exists('company_id', $attributes)) {
            $company_id = $attributes['company_id'];
        }
        if (array_key_exists('amount', $attributes)) {
            $amount = $attributes['amount'];
        }
        if (array_key_exists('gl_account_type_id', $attributes)) {
            $gl_account_type_id = $attributes['gl_account_type_id'];
        }
        if (array_key_exists('payment_id', $attributes)) {
            $payment_id = $attributes['payment_id'];
        }
        if (array_key_exists('phone', $attributes)) {
            $phone = $attributes['phone'];
        }
        if (array_key_exists('dr_cr_ind', $attributes)) {
            $dr_cr_ind = $attributes['dr_cr_ind'];
        }
        if (array_key_exists('tran_ref_txt', $attributes)) {
            $tran_ref_txt = $attributes['tran_ref_txt'];
        }
        if (array_key_exists('tran_desc', $attributes)) {
            $tran_desc = $attributes['tran_desc'];
        }
        if (array_key_exists('summ_sign', $attributes)) {
            $summ_sign = $attributes['summ_sign'];
        }
        if (array_key_exists('hist_sign', $attributes)) {
            $hist_sign = $attributes['hist_sign'];
        }
        if (array_key_exists('summ_action', $attributes)) {
            $summ_action = $attributes['summ_action'];
        }
        if (array_key_exists('hist_action', $attributes)) {
            $hist_action = $attributes['hist_action'];
        }

        //dd($payment_id, $attributes);


        //all data must be present
        if (!$company_id || !$amount || !$gl_account_type_id || !$phone) {
            //error
            $message = "Error. Please supply all required data";
            log_this($message);
            throw new \Exception($message);
        }


        DB::beginTransaction();

            if (!$summ_sign) {
                $summ_sign = "pos";
            }

            if (!$hist_sign) {
                $hist_sign = "pos";
            }

            if (!$summ_action) {
                $summ_action = "pos";
            }

            if (!$hist_action) {
                $hist_action = "pos";
            }

            //get company gl_account_summary record
            $gl_account_summary_data = "";
            $gl_account_data = GlAccount::where('company_id', $company_id)
                    ->where('gl_account_type_id', $gl_account_type_id)
                    ->first();

            if ($gl_account_data) {
                $gl_account_no = $gl_account_data->gl_account_no;
                //start get company  gl_account_summary record
                //if none, create record
                $gl_account_summary_data = GlAccountSummary::where('company_id', $company_id)
                        ->where('gl_account_no', $gl_account_no)
                        ->first();
            }

            if ($gl_account_summary_data) {

                //get gl account summary id
                $gl_account_summary_id = $gl_account_summary_data->id;
                $gl_account_summary_ledger_balance = $gl_account_summary_data->ledger_balance_calc;

            } else {

                //create new gl account summary record
                $gl_account_summary = new GlAccountSummary();

                $gl_account_summary_attributes['gl_account_no'] = $gl_account_no;
                $gl_account_summary_attributes['ledger_balance'] = '0';
                $gl_account_summary_attributes['ledger_balance_calc'] = '0';
                $gl_account_summary_attributes['cleared_balance'] = '0';
                $gl_account_summary_attributes['cleared_balance_calc'] = '0';
                $gl_account_summary_attributes['company_id'] = $company_id;
                $gl_account_summary_attributes['created_by'] = $system_id;
                $gl_account_summary_attributes['updated_by'] = $system_id;
                $gl_account_summary_attributes['created_by_name'] = $system_name;
                $gl_account_summary_attributes['updated_by_name'] = $system_name;

                $new_gl_account_summary_data = $gl_account_summary->create($gl_account_summary_attributes);

                $gl_account_summary_id = $new_gl_account_summary_data->id;
                $gl_account_summary_ledger_balance = $new_gl_account_summary_data->ledger_balance_calc;

            }
            //end get company gl_account_summary record

            //do action on current trans amount to ledger balance
            if ($summ_action == "pos") {
                $new_ledger_balance = $gl_account_summary_ledger_balance + $amount;
            } else {
                $new_ledger_balance = $gl_account_summary_ledger_balance - $amount;
            }

            //start save to gl_account_summary
            try {

                $gl_account_summary_update = GlAccountSummary::where('id', $gl_account_summary_id)->first();

                    $summ_symbol = "";
                    if ($summ_sign == "neg") { $summ_symbol = "-"; }

                    $gl_account_summary_update->ledger_balance = $summ_symbol . $new_ledger_balance;
                    $gl_account_summary_update->ledger_balance_calc = $new_ledger_balance;
                    $gl_account_summary_update->last_activity_date = $date;

                $gl_account_summary_update->save();

            } catch(\Exception $e) {

                DB::rollback();
                $message = "Error. Could not update $gl_account_no GlAccountSummary - " . $e->getMessage();
                log_this($message);
                throw new \Exception($message);

            }
            //end save to gl_account_summary


            //start save to gl_account_history
            try {

                $hist_symbol = "";
                if ($hist_sign == "neg") { $hist_symbol = "-"; }

                //create new gl account history record
                $gl_account_history = new GlAccountHistory();

                $gl_account_history_attributes['gl_account_no'] = $gl_account_no;
                $gl_account_history_attributes['amount'] = $hist_symbol . $amount;
                $gl_account_history_attributes['dr_cr_ind'] = $dr_cr_ind;
                $gl_account_history_attributes['company_id'] = $company_id;
                $gl_account_history_attributes['payment_id'] = $payment_id;
                $gl_account_history_attributes['phone'] = $phone;
                $gl_account_history_attributes['tran_ref_txt'] = $tran_ref_txt;
                $gl_account_history_attributes['tran_desc'] = $tran_desc;
                $gl_account_history_attributes['created_by'] = $system_id;
                $gl_account_history_attributes['updated_by'] = $system_id;
                $gl_account_history_attributes['created_by_name'] = $system_name;
                $gl_account_history_attributes['updated_by_name'] = $system_name;

                //dd($gl_account_history_attributes);

                $gl_account_history_data = $gl_account_history->create($gl_account_history_attributes);

            } catch(\Exception $e) {

                DB::rollback();
                $message = "Error. Could not create $gl_account_no GlAccountHistory - " . $e->getMessage();
                log_this($message);
                throw new \Exception($message);

            }
            //end save to gl_account_history

            //dd(DB::getQueryLog());


        DB::commit();

        return $gl_account_history_data;

    }

}
