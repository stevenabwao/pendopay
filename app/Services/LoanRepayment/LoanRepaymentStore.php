<?php

namespace App\Services\LoanRepayment;

use App\Entities\Account;
use App\Entities\LoanAccount;
use App\Entities\DepositAccount;
use App\Entities\LoanRepayment;
use App\Entities\LoanRepaymentSchedule;
use App\Entities\Company;
use App\Entities\CompanyUser;
use App\Entities\CompanyProduct;
use App\Entities\LoanProductSetting;
use App\Entities\LoanExposureLimit;
use App\Entities\LoanExposureLimitsDetail;
use App\User;
use App\Events\LoanAccountUpdated;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use Mail;
use App\Mail\NewLoanRepayment;

class LoanRepaymentStore
{

    public function createItem($attributes) {

        //dd($attributes);

        DB::beginTransaction();

        $company_user_id = "";
        $user_id = "";
        $phone_number = "";
        $amount = "";
        $account_no = "";
        $company_id = "";
        $mpesa_code = "";
        $payment_id = "";
        $payment_name = "";
        $transfer = "";
        $tran_ref_txt = "";
        $tran_desc = "";
        $loan_fully_paid = false;

        if (array_key_exists('company_user_id', $attributes)) {
            $company_user_id = $attributes['company_user_id'];
        }
        if (array_key_exists('user_id', $attributes)) {
            $user_id = $attributes['user_id'];
        }
        if (array_key_exists('phone', $attributes)) {
            $phone_number = $attributes['phone'];
        }
        if (array_key_exists('amount', $attributes)) {
            $amount = $attributes['amount'];
        }
        if (array_key_exists('account_no', $attributes)) {
            $account_no = $attributes['account_no'];
        }
        if (array_key_exists('company_id', $attributes)) {
            $company_id = $attributes['company_id'];
        }
        if (array_key_exists('mpesa_code', $attributes)) {
            $mpesa_code = $attributes['mpesa_code'];
        }
        if (array_key_exists('payment_id', $attributes)) {
            $payment_id = $attributes['payment_id'];
        }
        if (array_key_exists('payment_name', $attributes)) {
            $payment_name = $attributes['payment_name'];
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

        //store total amount in new variable for use in comparisons later
        $total_amount = $amount;


        //*************** start data *******************

        //get companyuserid
        //if no account_no is entered, use the senders phone number as account_no
        $phone_account_no = $phone_number;

        //if account_no is entered, use the submitted account_no/ phone
        if ($account_no){
            try{
                $phone_account_no = getDatabasePhoneNumber($account_no);
            } catch (\Exception $e) {
                //dd($e);
                DB::rollback();
                $show_message = "Invalid account number";
                log_this($show_message);
                $message["message"] = $show_message;

                $payment_update = Payment::find($payment_id)
                    ->update([
                        'fail_reason' => $show_message,
                        'failed' => '1',
                        'failed_at' => $date
                    ]);

                return show_json_error($message);
            }
        }
        //$account_data = getCompanyUserData($company_id, $phone_account_no);
        //dd($account_data);

        //get account_data
        if ($phone_account_no) {

            try {

                $account_data = Account::where('company_id', $company_id)
                        ->where(function($q) use ($phone_account_no){
                            $q->where('account_no', '=', $phone_account_no);
                            $q->orWhere('phone', '=', $phone_account_no);
                        })
                        ->first();

            } catch(\Exception $e) {

                $show_message = $e->getMessage() . ". Invalid account number.";
                log_this($show_message);
                throw new StoreResourceFailedException($show_message);

            }

        }
        //dd($account_data);

        //if no account record exists, throw an error
        if (!$account_data) {
            //throw an error, account record does not exist
            //throw new StoreResourceFailedException('Non existent account!!! Please check the account_no');
            //$contact_phone = "0720743211";
            $show_message = "Wrong account number entered!!!";
            log_this($show_message);
            throw new StoreResourceFailedException($show_message);
        }


        $company_id = $account_data->company_id;
        $company_user_id = $account_data->company_user_id;
        $user_id = $account_data->user_id;
        $savings_account_no = $account_data->account_no;


        //find deposit account no
        $deposit_account_data = DepositAccount::where('ref_account_no', $savings_account_no)->first();
        if (!$deposit_account_data) {
            $show_message = "Deposit account does not exist!!!";
            log_this($show_message);
            throw new StoreResourceFailedException($show_message);
        }
        $deposit_account_no = $deposit_account_data->account_no;

        //user data
        $user_data = User::find($user_id);
        if (!$user_data) {
            $show_message = "User data does not exist!!!";
            log_this($show_message);
            throw new StoreResourceFailedException($show_message);
        }
        $user_id = $user_data->id;
        $first_name = $user_data->first_name;
        $last_name = $user_data->last_name;

        $company_user_data = CompanyUser::find($company_user_id);

        //*************** end data *******************


        //define statuses
        $status_open = config('constants.status.open');
        $status_unpaid = config('constants.status.unpaid');
        $status_paid = config('constants.status.paid');

        //gl account types
        $mobile_loans_principal_gl_account_type = config('constants.gl_account_types.mobile_loans_principal');
        $mobile_loans_interest_gl_account_type = config('constants.gl_account_types.mobile_loans_interest');
        $mobile_loans_interest_income_gl_account_type = config('constants.gl_account_types.mobile_loans_interest_income');

        //get company user
        $company_user = CompanyUser::find($company_user_id);

        //check for user's active loan in company
        $user_loan_data = LoanAccount::where('company_user_id', $company_user_id)
                                      ->where('company_id', $company_id)
                                      ->where('status_id', $status_open)
                                      ->first();

        //if user has balance, repay here
        if ($user_loan_data) {

            $loan_bal = $user_loan_data->loan_bal_calc;
            $loan_amt = $user_loan_data->loan_amt_calc;
            $repayment_amt = $user_loan_data->repayment_amt_calc;
            $loan_account_id = $user_loan_data->id;
            $loan_account_no = $user_loan_data->account_no;
            $maturity_at = $user_loan_data->maturity_at;

            //get repayment schedules
            try {
                $loan_repayment_schedules = LoanRepaymentSchedule::where('loan_account_id', $loan_account_id)
                                      ->where('company_user_id', $company_user_id)
                                      ->get();

            } catch(\Exception $e) {

                DB::rollback();
                $message_text = $e->getMessage();
                log_this($message_text);
                $show_message = "Error processing loan repayment. Please try again later. ";
                $show_message .= $message_text;
                //$message["message"] = $show_message;
                throw new StoreResourceFailedException($show_message);

            }
            //dd($loan_repayment_schedules);

            try {

                //store the sum of repayments
                $sum_repayments = 0;

                foreach ($loan_repayment_schedules as $loan_repayment_schedule) {

                    $fully_paid = false;
                    $repayment_amount = $loan_repayment_schedule->amount;

                    //get loan repayment amount
                    $loan_repayment_update = LoanRepaymentSchedule::find($loan_repayment_schedule->id);
                    $paid_amt = $loan_repayment_update->paid_amt;
                    $repayment_amount_bal = $repayment_amount - $paid_amt;

                    if (($amount > 0) && ($repayment_amount_bal > 0)) {
                        //if repay amt is more than amount paid
                        if ($repayment_amount_bal < $amount) {
                            $repaid_amount = $repayment_amount_bal;
                        } else {
                            $repaid_amount = $amount;
                        }

                        //if amt to be paid is less than or equal to amt received, set to fully paid
                        if ($repayment_amount_bal <= $amount) {
                            $fully_paid = true;
                        }
                        //add to sum of repayments
                        $sum_repayments = $sum_repayments + $repaid_amount;

                        if ($fully_paid) {
                            $loan_repayment_update->status_id = $status_paid;
                            $loan_repayment_update->paid_at = getCurrentDate(1);
                        }
                        //update already paid amt plus new repaid amount
                        $total_repayment = $paid_amt + $repaid_amount;
                        $loan_repayment_update->paid_amt = $total_repayment;

                        //dump($total_repayment);

                        $loan_repayment_update->save();

                        $amount = $amount - $repaid_amount;
                        //dump($total_repayment);

                    }

                }

                //dd("repay here");

            } catch(\Exception $e) {

                DB::rollback();
                $message_text = $e->getMessage();
                log_this($message_text);
                $show_message = "Error processing loan repayment. Please try again later.";
                $show_message .= $message_text;
                //$message["message"] = $show_message;
                throw new StoreResourceFailedException($show_message);

            }

            //dd($sum_repayments);

            //start update loan account loan_bal value
            $new_loan_bal = $loan_bal - $sum_repayments;

            $user_loan_data->loan_bal = $new_loan_bal;

            if ($new_loan_bal == 0) {
                //update loan account status to paid
                $user_loan_data->status_id = $status_paid;
                $loan_fully_paid = true;

                //check if user has paid loan on time
                try {

                    //if user has paid back loan on time, increase their loan exposure limit
                    //get last loan repayment date
                    $loan_repayment_schedule_date = LoanRepaymentSchedule::where('loan_account_id', $loan_account_id)
                                      ->orderBy('repayment_at', 'desc')
                                      ->first();
                    $last_repayment_date = $loan_repayment_schedule_date->repayment_at;

                    //start get company loan exposure limit settings
                    $mobile_loan_product_id = config('constants.account_settings.mobile_loan_product_id');
                    $loan_product_setting = getCompanyLoanProductSetting($company_id, $mobile_loan_product_id);

                    $initial_exposure_limit = $loan_product_setting->initial_exposure_limit;
                    $increase_exposure_limit = $loan_product_setting->increase_exposure_limit;
                    $decrease_exposure_limit = $loan_product_setting->decrease_exposure_limit;

                    //dd($loan_product_setting);
                    //end get company loan exposure limit settings

                    //get user loan exposure limit
                    $loan_exposure_limit_data = LoanExposureLimit::where('company_user_id', $company_user_id)->first();

                } catch(\Exception $e) {

                    DB::rollback();
                    $message_text = $e->getMessage();
                    log_this($message_text);
                    $show_message = "Error processing loan repayment. Please try again later.";
                    $show_message .= $message_text;
                    //$message["message"] = $show_message;
                    throw new StoreResourceFailedException($show_message);

                }
                //dump($loan_exposure_limit_data);

                //does the user have existing loan exposure limit data?
                if ($loan_exposure_limit_data) {
                    //assign loan based on existing exposure limit
                    $user_loan_exposure_limit = $loan_exposure_limit_data->limit;
                } else {
                    //use company default exposure limit
                    $user_loan_exposure_limit = $initial_exposure_limit;

                    //create a new exposure limit
                    //start create new loan user exposure limit
                    /*
                    try {

                        $loan_exposure_limit_entry = new LoanExposureLimit();

                        $loan_exposure_limit_attributes['limit'] = $user_loan_exposure_limit;
                        $loan_exposure_limit_attributes['company_id'] = $company_id;
                        $loan_exposure_limit_attributes['user_id'] = $user_id;
                        $loan_exposure_limit_attributes['company_user_id'] = $company_user_id;

                        $new_loan_exposure_limit_entry = $loan_exposure_limit_entry::create($loan_exposure_limit_attributes);

                    } catch(\Exception $e) {

                        DB::rollback();
                        $message_text = "Error creating new user exposure limit entry - " . $e->getMessage();
                        //dd($message_text);
                        log_this($message_text);
                        $show_message = "Error processing loan. Please try again later.";
                        //return show_json_error($message);
                        throw new StoreResourceFailedException($show_message);

                    }
                    */
                    //end create new loan user exposure limit

                    //start create new loan user exposure limit details
                    /*
                    try {

                        $loan_exposure_limit_detail_entry = new LoanExposureLimitsDetail();

                        $loan_exposure_limit_detail_attributes['limit'] = $user_loan_exposure_limit;
                        $loan_exposure_limit_detail_attributes['company_id'] = $company_id;
                        $loan_exposure_limit_detail_attributes['user_id'] = $user_id;
                        $loan_exposure_limit_detail_attributes['company_user_id'] = $company_user_id;
                        $loan_exposure_limit_detail_attributes['loan_exposure_limit_id'] = $new_loan_exposure_limit_entry->id;

                        $new_loan_exposure_limit_detail_entry = $loan_exposure_limit_detail_entry::create($loan_exposure_limit_detail_attributes);

                    } catch(\Exception $e) {

                        DB::rollback();
                        $message_text = "Error creating new user exposure limit detail entry - " . $e->getMessage();
                        //dd($message_text);
                        log_this($message_text);
                        $show_message = "Error processing loan. Please try again later.";
                        //return show_json_error($message);
                        throw new StoreResourceFailedException($show_message);

                    }
                    */
                    //end create new loan user exposure limit details

                }

                //dd($user_loan_exposure_limit, $loan_account_id, $loan_account_no, $repayment_amt, $maturity_at);

                $new_exposure_limit_detail_comments = "";
                $current_date_obj = getCurrentDateObj();
                $current_date_day = $current_date_obj->endOfDay();
                $loan_details = "loan account id - $loan_account_id, loan account no - $loan_account_no,";
                $loan_details .= "loan amount - $repayment_amt, loan maturity date - " . formatDisplayDate($maturity_at);
                $loan_details .= ", loan repaid at - " . formatDisplayDate($current_date_obj);

                //dd("here", $loan_details);
                $calculation_limit = "";

                if ($last_repayment_date > $current_date_day) {
                    //payment made on time, increase user loan exposure limit
                    $new_user_loan_exposure_limit = $user_loan_exposure_limit + $increase_exposure_limit;
                    $new_exposure_limit_detail_comments = "Timely loan repayment: $loan_details";
                    $calculation_limit = $increase_exposure_limit;
                } else {
                    //late payment, decrease user loan exposure limit
                    $new_user_loan_exposure_limit = $user_loan_exposure_limit - $decrease_exposure_limit;
                    $new_exposure_limit_detail_comments = "Late loan repayment: $loan_details";
                    $calculation_limit = -$decrease_exposure_limit;
                }


                try{

                    //$loan_exposure_limit_data = LoanExposureLimit::where('company_user_id', $company_user_id)->first();

                    //save new user loan exposure limit
                    $new_limit_update = $loan_exposure_limit_data
                            ->update([
                                'limit' => $new_user_loan_exposure_limit
                            ]);

                } catch(\Exception $e) {

                    DB::rollback();
                    //dd($e);
                    $message_text = $e->getMessage();
                    log_this($message_text);
                    $show_message = "Error processing loan repayment. Please try again later.";
                    $show_message .= $message_text;
                    //$message["message"] = $show_message;
                    throw new StoreResourceFailedException($show_message);

                }


                //start create new loan user exposure limit details
                try {

                    $loan_exposure_limit_detail_entry = new LoanExposureLimitsDetail();

                    $loan_exposure_limit_detail_attributes['limit'] = $calculation_limit;
                    $loan_exposure_limit_detail_attributes['current_limit'] = $new_user_loan_exposure_limit;
                    $loan_exposure_limit_detail_attributes['company_id'] = $company_id;
                    $loan_exposure_limit_detail_attributes['user_id'] = $company_user->user->id;
                    $loan_exposure_limit_detail_attributes['comments'] = $new_exposure_limit_detail_comments;
                    $loan_exposure_limit_detail_attributes['company_user_id'] = $company_user_id;
                    $loan_exposure_limit_detail_attributes['loan_exposure_limit_id'] = $loan_exposure_limit_data->id;

                    $new_loan_exposure_limit_detail_entry = $loan_exposure_limit_detail_entry::create($loan_exposure_limit_detail_attributes);

                } catch(\Exception $e) {

                    DB::rollback();
                    $message_text = "Error creating new user exposure limit detail entry - " . $e->getMessage();
                    //dd($message);
                    log_this($message_text);
                    $show_message = "Error processing loan repayment. Please try again later.";
                    $show_message .= $message_text;
                    throw new StoreResourceFailedException($show_message);

                }
                //end create new loan user exposure limit details

            }

            try {

                $user_loan_data->save();
                //end update loan account loan_bal value

            } catch(\Exception $e) {

                DB::rollback();
                $message_text = $e->getMessage();
                log_this($message_text);
                $show_message = "Error processing loan repayment. Please try again later.";
                $show_message .= $message_text;
                //$message["message"] = $show_message;
                //return show_json_error($show_message);
                throw new StoreResourceFailedException($show_message);

            }


            //start save loan account balance data
            try {

                //start update loan account loan_bal value
                $new_loan_bal = $loan_bal - $sum_repayments;

                $user_loan_data->loan_bal = -$new_loan_bal;
                $user_loan_data->loan_bal_calc = $new_loan_bal;

                if ($new_loan_bal == 0) {
                    //update loan account status to paid
                    $user_loan_data->status_id = $status_paid;
                    $loan_fully_paid = true;
                }

                $user_loan_data->save();
                //end update loan account loan_bal value

                //call loan account update event
                $new_user_loan_data = LoanAccount::findOrFail($user_loan_data->id);
                event(new LoanAccountUpdated($new_user_loan_data));

            } catch(\Exception $e) {

                DB::rollback();
                $message_text = $e->getMessage();
                log_this($message_text);
                $show_message = "Error processing loan repayment. Please try again later.";
                $show_message .= $message_text;
                //$message["message"] = $show_message;
                //return show_json_error($show_message);
                throw new StoreResourceFailedException($show_message);

            }
            //end save loan account balance data


            //start save loan principal gl account data
            //get gl account
            try {

                //start get mobile loan principal gl account
                $mobile_loans_principal_gl_account_no = get_gl_account_number($mobile_loans_principal_gl_account_type, $company_id);
                //end get mobile loan principal gl account

            } catch(\Exception $e) {

                DB::rollback();
                $message_text = "Error getting  mobile_loans_principal_gl_account_no - " . $e->getMessage();
                //dd($message_text);
                log_this($message_text);
                $show_message = "Error processing loan repayment. Please try again later.";
                $show_message .= $message_text;
                //$message["message"] = $show_message;
                //return show_json_error($message);
                throw new StoreResourceFailedException($show_message);

            }

            try {

                //check for repayments made to this loan account
                $loan_repayment_sum = LoanRepayment::where('loan_account_id', $loan_account_id)
                                                ->sum('amount');

                //get total repayments
                $total_repayments = $loan_repayment_sum + $sum_repayments;

                //if loan principal is already paid, ignore
                if ($loan_repayment_sum == $loan_amt) {
                    $amount_to_store = 0;
                } else {
                    //get balance principal - deduct sum already paid that is less than loan amount
                    if ($total_repayments > $loan_amt) {
                        $amount_to_store = $loan_amt - $loan_repayment_sum;
                    } else {
                        $amount_to_store = $sum_repayments;
                    }
                }

                //dd($total_repayments, $amount_to_store);

                //dump($loan_repayment_sum, $loan_amt);
                //check if repayment is less than principal amount
                if ($amount_to_store > 0) {

                    //store data in loans principal gl account
                    $dr_cr_ind = "DR";
                    if ($transfer != "1") {
                        $tran_ref_txt = "mpesa_code - $mpesa_code - payment_name - $payment_name - payment_id - $payment_id";
                        $tran_desc = "Repayment - loan acct no - $loan_account_no";
                    }
                    $principal_summary_sign = "pos";
                    $principal_hist_sign = "neg";
                    $principal_summary_action = "neg";

                    createGlAccountEntry($payment_id, $amount_to_store, $mobile_loans_principal_gl_account_type,
                                         $company_id, $phone_number, $dr_cr_ind, $tran_ref_txt, $tran_desc, $principal_summary_sign,
                                         $principal_hist_sign, $principal_summary_action);
                    //end save mobile loan principal gl account entry

                }

                //dd($loan_repayment_sum, $amount_to_store, $principal_bal);

            } catch(\Exception $e) {

                DB::rollback();
                $message_text = "Error creating  mobile_loans_principal_gl_account entry - " . $e->getMessage();
                //dd($message_text);
                log_this($message_text);
                $show_message = "Error processing loan repayment. Please try again later.";
                $show_message .= $message_text;
                //$message["message"] = $show_message;
                //return show_json_error($message);
                throw new StoreResourceFailedException($show_message);

            }
            //end save loan principal gl account data


            //start get loan interest gl account
            //get gl account
            try {

                //start get mobile loan interest gl account
                $mobile_loans_interest_gl_account_no = get_gl_account_number($mobile_loans_interest_gl_account_type, $company_id);
                //dd($mobile_loans_interest_gl_account_no);
                //end get mobile loan interest gl account

            } catch(\Exception $e) {

                DB::rollback();
                $message_text = "Error getting  mobile_loans_interest_gl_account_no - " . $e->getMessage();
                //dd($message_text);
                log_this($message_text);
                $show_message = "Error processing loan repayment. Please try again later.";
                $show_message .= $message_text;
                //$message["message"] = $show_message;
                //return show_json_error($message);
                throw new StoreResourceFailedException($show_message);

            }

            //start get loan interest income gl account
            //get gl account
            try {

                //start get mobile loan interest gl account
                $mobile_loans_interest_income_gl_account_no = get_gl_account_number($mobile_loans_interest_income_gl_account_type, $company_id);
                //dd($mobile_loans_interest_income_gl_account_no);
                //end get mobile loan interest gl account

            } catch(\Exception $e) {

                DB::rollback();
                $message_text = "Error getting  mobile_loans_interest_income_gl_account_no - " . $e->getMessage();
                //dd($message_text);
                log_this($message_text);
                $show_message = "Error processing loan repayment. Please try again later.";
                $show_message .= $message_text;
                //$message["message"] = $show_message;
                //return show_json_error($message);
                throw new StoreResourceFailedException($show_message);

            }


            try {

                //check for repayments made to this loan account
                $loan_repayment_sum = LoanRepayment::where('loan_account_id', $loan_account_id)
                                                ->sum('amount');

                //get total repayments
                $total_repayments = $loan_repayment_sum + $sum_repayments;

                $interest = $repayment_amt - $loan_amt;

                if ($total_repayments >= $loan_amt) {

                    //if user had already paid some interst before
                    if ($loan_repayment_sum > $loan_amt) {
                        $interest_already_paid = $loan_repayment_sum - $loan_amt;
                    } else {
                        $interest_already_paid = 0;
                    }

                    //get the interest paid now
                    $total_interest_now = $total_repayments - $loan_amt;

                    $amount_to_store = $total_interest_now - $interest_already_paid;

                } else {

                    $amount_to_store = 0;

                }

                //dd($total_repayments, $amount_to_store);

                //check if total repayment is more than principal amount and less than original balance (principal + interest)
                if ($amount_to_store > 0) {

                    //store data in loans interest gl account
                    //start save mobile loan interest gl account entry
                    $dr_cr_ind = "DR";
                    if ($transfer != "1") {
                        $tran_ref_txt = "mpesa_code - $mpesa_code - payment_name - $payment_name - payment_id - $payment_id";
                        $tran_desc = "Repayment - loan acct no - $loan_account_no";
                    }
                    $int_summary_sign = "pos";
                    $int_hist_sign = "neg";
                    $int_summary_action = "neg";
                    createGlAccountEntry($payment_id, $amount_to_store, $mobile_loans_interest_gl_account_type,
                                         $company_id, $phone_number, $dr_cr_ind, $tran_ref_txt, $tran_desc, $int_summary_sign,
                                         $int_hist_sign, $int_summary_action);
                    //end save mobile loan interest gl account entry

                    //start save mobile loan interest income gl account entry
                    $dr_cr_ind = "CR";
                    if ($transfer != "1") {
                        $tran_ref_txt = "$mpesa_code - payment_name - $payment_name - payment_id - $payment_id";
                        $tran_desc = "Repayment - loan acct no - $loan_account_no";
                    }
                    $int_income_summary_sign = "neg";
                    $int_income_hist_sign = "neg";
                    $int_income_summary_action = "pos";
                    createGlAccountEntry($payment_id, $amount_to_store, $mobile_loans_interest_income_gl_account_type,
                                         $company_id, $phone_number, $dr_cr_ind, $tran_ref_txt, $tran_desc, $int_income_summary_sign,
                                         $int_income_hist_sign, $int_income_summary_action);
                    //end save mobile loan interest income gl account entry

                }

            } catch(\Exception $e) {

                DB::rollback();
                $message_text = "Error creating  mobile_loans_interest_gl_account entry - " . $e->getMessage();
                //dd($message_text);
                log_this($message_text);
                $show_message = "Error processing loan repayment. Please try again later.";
                $show_message .= $message_text;
                //$message["message"] = $show_message;
                //return show_json_error($message);
                throw new StoreResourceFailedException($show_message);

            }
            //end save loan interest gl account data

            //dd($loan_repayment_sum);


            //start save loan repayment data
            try {

                $ref_txt = "";
                if ($payment_name && $mpesa_code && $payment_id) {
                    //$ref_txt = $payment_name . " - " . $mpesa_code;
                    $ref_txt = "mpesa_code - $mpesa_code - payment_name - $payment_name - payment_id - $payment_id";
                }

                if ($transfer == "1") {
                    $ref_txt = $tran_desc;
                }

                $new_loan_repayment = new LoanRepayment();

                    $new_loan_repayment->loan_account_id = $loan_account_id;
                    $new_loan_repayment->loan_account_no = $loan_account_no;
                    $new_loan_repayment->company_user_id = $company_user_id;
                    if ($payment_id){
                        $new_loan_repayment->payment_id = $payment_id;
                    }
                    $new_loan_repayment->amount = $sum_repayments;
                    $new_loan_repayment->ref_txt = $ref_txt;
                    $new_loan_repayment->company_id = $company_id;
                    $new_loan_repayment->created_by = "-1";

                $new_loan_repayment->save();

            } catch(\Exception $e) {

                DB::rollback();
                $message_text = $e->getMessage();
                //dd($message_text);
                log_this($message_text);
                $show_message = "Error processing loan repayment. Please try again later.";
                $show_message .= $message_text;
                //$message["message"] = $show_message;
                throw new StoreResourceFailedException($show_message);

            }
            //end save loan repayment data

            //dd($loan_repayment_sum);


        }

        DB::commit();


        //******************* start send user sms ********************//

        $company_data = Company::find($company_id);
        $company_name = $company_data->name;
        $msg = "";

        if ($user_data) {
            $full_names = titlecase($user_data->first_name . " " . $user_data->last_name);
            $msg = "Dear $full_names, your";
        } else {
            $msg = "Your";
        }

        $sum_repayments_fmt = formatCurrency($sum_repayments);
        $new_loan_bal_fmt = formatCurrency($new_loan_bal);

        $msg .= " loan repayment of $sum_repayments_fmt has been received successfully.";
        if($new_loan_bal > 0) {
            $msg .= "Your loan balance is: $new_loan_bal_fmt.";
        }
        if($loan_fully_paid) {
            $msg .= "Your current loan is fully paid.";
        }
        $msg .= " Regards, $company_name";

        //dd($msg);
        $sms_type_id = config('constants.sms_types.company_sms');

        //send sms to loan account user
        $result = createSmsOutbox($msg, $phone_number, $sms_type_id, $company_id, $company_user_id);

        //******************* end send user sms ********************//


        //******************* start send user email ********************//

        //send the user loan repayment breakdown status
        $table_response = buildTableLoanRepaymentData($loan_account_id);

        //set company user data
        $email = $company_user->user->email;
        $company_user['message'] = $table_response;
        $company_user['sum_repayments'] = $sum_repayments;
        //dd($email, $company_user);

        //send email to loan account user
        /*
        if ($email) {
            Mail::to($email)
                ->send(new NewLoanRepayment($company_user));
        }
        */

        //get email data
        $first_name = titlecase($company_user->user->first_name);
        $last_name = titlecase($company_user->user->last_name);
        $company_name = $company_user->company->name;
        $company_id = $company_user->company->id;
        $local_phone = $company_user->user->phone;
        $phone_country = $company_user->user->phone_country;
        $message = $company_user->message;
        $user_phone = getDatabasePhoneNumber($local_phone, $phone_country);
        $localised_phone = getLocalisedPhoneNumber($local_phone, $phone_country);

        $company_short_name = $company_user->company->short_name;
        if (!$company_short_name) {
            $company_short_name = $company_name;
        }

        //start send email to queue
        $subject = 'Dear ' . $first_name . ', Your Loan Repayment To ' . $company_short_name;
        $title = $subject;

        $email_salutation = "Dear " . $first_name . ",<br><br>";

        $email_text = "Thank you for making repayment of <strong>" . formatCurrency($sum_repayments) . "</strong>";
        $email_text .= " for your loan at $company_name. <br><br>";
        if($new_loan_bal > 0) {
            $email_text .= "Your loan balance is:" . formatCurrency($new_loan_bal) . ".<br><br>";
        }
        if($loan_fully_paid) {
            $email_text .= "Your current loan is fully paid.<br><br>";
        }
        $email_text .= "Your loan repayment breakdown is as follows: <br>";

        $table_text = $table_response;

        $panel_text = "";

        $email_footer = "Regards,<br>";
        $email_footer .= "$company_short_name Management";

        $parent_id = 0;
        $reminder_message_id = 0;

        $result = sendTheEmailToQueue($email, $subject, $title, $company_name, $email_text, $email_salutation,
        $company_id, $email_footer, $panel_text, $table_text, $parent_id, $reminder_message_id);
        //end send email to queue

        //dd($email_text);


        //dd($email, $subject, $title, $company_name, $email_text, $email_salutation,
        //$company_id, $email_footer, $panel_text, $table_text, $parent_id, $reminder_message_id);

        //******************* end send user email ********************//

        $response['account'] = $account_data;
        $response['deposit_account'] = $deposit_account_data;
        $response['user'] = $user_data;
        $response['company_user'] = $company_user_data;
        $response['company'] = $company_user_data->company;

        return json_encode($response);

    }

}
