<?php

namespace App\Services\Payment;

use App\Entities\Account;
use App\Entities\Company;
use App\Entities\CompanyUser;
use App\Entities\Payment;
use App\Entities\PaymentDeposit;
use App\Entities\DepositAccount;
use App\Entities\LoanAccount;
use App\Mail\NewUserPayment;
use App\Services\Deposit\DepositStore;
use App\Services\User\CreateUserAccount;
use App\Services\Shares\SharesDepositStore;
use App\Services\Payment\PaymentDepositStore;
use App\Services\LoanRepayment\LoanRepaymentStore;
use App\User;
use Carbon\Carbon;
use Mail;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class PaymentManualStore
{

    use Helpers;

    public function createItem($attributes) {

        //dd($attributes);

        $mpesa_payment_id = config('constants.payment_methods.mpesa');
        $cash_payment_id = config('constants.payment_methods.cash');
        $bank_payment_id = config('constants.payment_methods.bank');
        $cheque_payment_id = config('constants.payment_methods.cheque');

        $repost = false;
        $date = Carbon::now();
        $date = $date->toDateTimeString();

        $amount = "";
        $full_name = "";
        $phone_number = "";
        $paybill_number = "";
        $account_no = "";
        $trans_id = "";
        $shares = "";
        $src_ip = "";
        $tran_ref_txt = "";
        $tran_desc = "";
        $bank_name = "";
        $cheque_no = "";
        $mpesa_code = "";
        $payment_at = "";
        $payment_method_id = "";
        $top_company_id = "";

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
        }
        if (array_key_exists('payment_at', $attributes)) {
            $payment_at = $attributes['payment_at'];
            $attributes['payment_at'] = $payment_at;
        }
        if (array_key_exists('payment_method_id', $attributes)) {
            $payment_method_id = $attributes['payment_method_id'];
        }
        if (array_key_exists('company_id', $attributes)) {
            $top_company_id = $attributes['company_id'];
        }

        //dd($attributes);

        //is this a repost? a repost will have an id attribute
        if (array_key_exists('id', $attributes)) {

            $repost = true;

            $payment_id = $attributes['id'];
            //get existing payment data
            $payment_result = Payment::find($payment_id);
            //dd($attributes, $payment_result);

            $amount =  $payment_result->amount;
            $full_name =  titlecase($payment_result->full_name);
            $phone_number =  $payment_result->phone;
            $paybill_number =  $payment_result->paybill_number;
            $account_no =  $payment_result->account_no;
            $trans_id =  $payment_result->trans_id;
            $shares =  $payment_result->shares;
            $src_ip =  $payment_result->src_ip;

            //update payment
            $payment_update = $payment_result->update($attributes);
            //end update payment

            //reset the attributes
            $attributes['amount'] = $amount;
            $attributes['full_name'] = $full_name;
            $attributes['phone'] = $phone_number;
            $attributes['paybill_number'] = $paybill_number;
            $attributes['account_no'] = $account_no;
            $attributes['trans_id'] = $trans_id;
            $attributes['shares'] = $shares;
            $attributes['src_ip'] = $src_ip;
            //dd($attributes, $payment_result);

        } else {

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
            if (array_key_exists('paybill_number', $attributes)) {
                $paybill_number = $attributes['paybill_number'];
            }
            if (array_key_exists('trans_id', $attributes)) {
                $trans_id = $attributes['trans_id'];
            }

            if (array_key_exists('shares', $attributes)) {
                $shares = $attributes['shares'];
            }
            if (array_key_exists('src_ip', $attributes)) {
                $src_ip = $attributes['src_ip'];
            }

            //get sent data
            $top_account_no =  $account_no;

            //attach attributes
            $attributes['created_by_name'] = 'pendom';
            $attributes['updated_by_name'] = 'pendom';

            //dd($attributes);

            //create new payment
            $payment = new Payment();
            $payment_result = $payment->create($attributes);
            $payment_id = $payment_result->id;
            //end create payment

        }

        //get company data using paybill number
        $company_id = "";

        //start save payment report section data
        try {

            //report section items
            $report_section_payments = config('constants.report_section.payments');

            $current_date_obj_new = getCurrentDateObj();
            $data_parent_id = $payment_id;
            $ref_txt = "new payment";
            if (!$tran_ref_txt) {
                $tran_ref_txt = $ref_txt;
            }
            if (!$tran_desc) {
                $tran_desc = $ref_txt;
            }
            $amount_to_store = $amount;
            $mpesa_code = $trans_id;
            $result = createNewReportSectionData($report_section_payments, $company_id,
                $amount_to_store, $current_date_obj_new, $data_parent_id, $payment_id,
                $company_user_id, $mpesa_code, $tran_ref_txt, $tran_desc);

        } catch (\Exception $e) {

            DB::rollback();
            //dd($e);
            $message_text = $e->getMessage();
            log_this($message_text);
            $show_message = "Error processing payment. Please try again later.";
            //$show_message .= $message_text;
            throw new StoreResourceFailedException($show_message);

        }
        //end save payment report section data

        return show_json_success($response);

    }

}