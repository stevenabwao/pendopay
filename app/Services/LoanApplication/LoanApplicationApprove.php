<?php

namespace App\Services\LoanApplication;

use App\Entities\LoanApplication;
use App\Entities\DepositAccount;
use App\Entities\Account;
use App\Entities\LoanProductSetting;
use App\Entities\LoanExposureLimit;
use App\Entities\LoanExposureLimitsDetail;
use App\Entities\LoanRepaymentSchedule;
use App\Entities\LoanAccount;
use App\Entities\DepositAccountSummary;
use App\Entities\CompanyUser;
use App\Entities\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;

class LoanApplicationApprove
{

    public function approveItem($id, $attributes=array()) {

        DB::beginTransaction();

        $message = array();

        $admin_approval = "";
        $submit_btn = "";
        $approval_comments = "";
        $trans_status = "";

        if (array_key_exists('admin_approval', $attributes)) {
            $admin_approval = $attributes['admin_approval'];
        }

        if (array_key_exists('submit_btn', $attributes)) {
            $submit_btn = $attributes['submit_btn'];
        }

        if (array_key_exists('trans_status', $attributes)) {
            $trans_status = $attributes['trans_status'];
        }


        //get loan application details
        $loan_application = LoanApplication::find($id);

        //start get loan application settings
        $approved_term_id = $loan_application->term_id;
        $approved_term_value = $loan_application->term_value;
        $approved_loan_amt = $loan_application->loan_amt;
        $company_user_id = $loan_application->company_user_id;
        $company_id = $loan_application->company_id;
        $user_phone = $loan_application->companyuser->user->phone;
        //end get loan application settings

        

        //check whether company requires reg and whether user has paid reg fees
        //registration event == 1
        $event_type_id = 1;
        $registration_amount = getCompanyEventCost($company_id, $event_type_id);

        //dd("here", $loan_application);

        //get user details
	    $company_user_data = CompanyUser::find($company_user_id);

        /* if ($registration_amount >0 && $company_user_data->registration_paid == 0) {

            //user has not paid registration fees, show user the message
            $show_message = "You are not fully registered. Please pay registration fee of $registration_amount to proceed.";
            log_this($show_message . "<br> Loan Application Id -" . $loan_application->id);
            //dd($show_message);
            DB::rollback();
            throw new StoreResourceFailedException($show_message);
            //$message["message"] = $show_message;
            //return show_json_error($message);

        } */

        try {

            //get the company loan product settings
            $loan_product_setting = LoanProductSetting::where('company_product_id', $loan_application->company_product_id)
            ->first();

            //start get loan product settings
            $borrow_criteria = $loan_product_setting->borrow_criteria;
            $max_loan_limit = $loan_product_setting->max_loan_limit;
            $minimum_contributions = $loan_product_setting->minimum_contributions;
            $minimum_contributions_condition_id = $loan_product_setting->minimum_contributions_condition_id;
            $loan_limit_calculation_id = $loan_product_setting->loan_limit_calculation_id;
            $initial_exposure_limit = $loan_product_setting->initial_exposure_limit;
            $interest_type = $loan_product_setting->interest_type;
            $interest_method = $loan_product_setting->interest_method;
            $interest_amount = $loan_product_setting->interest_amount;
            $interest_cycle = $loan_product_setting->interest_cycle;
            $loan_instalment_period = $loan_product_setting->loan_instalment_period;
            $loan_instalment_cycle = $loan_product_setting->loan_instalment_cycle;
            $loan_product_status = $loan_product_setting->loan_product_status;
            $loans_exceeding_limit = $loan_product_setting->loans_exceeding_limit;
            $loan_approval_method = $loan_product_setting->loan_approval_method;
            $max_loan_applications_per_day = $loan_product_setting->max_loan_applications_per_day;
            $min_loan_limit = $loan_product_setting->min_loan_limit;
            $initial_loan_limit = $loan_product_setting->initial_loan_limit;
            $loan_duration_cycle = $loan_product_setting->loan_duration_cycle;
            $loan_duration_period = $loan_product_setting->loan_duration_period;
            //end get loan product settings

        } catch(\Exception $e) {

            DB::rollback();
            $show_message = "Loan product setting not found. Company_id:  $company_id -- ";
            $show_message .= " Company Product ID:  $loan_application->company_product_id.";
            log_this($show_message . "<br> Loan Application Id -" . $loan_application->id);
            throw new StoreResourceFailedException($show_message);

        }

        //set variables
        $mobile_loan_product_id = config('constants.account_settings.mobile_loan_product_id');

        //statuses
        $status_approved = config('constants.status.approved');
        $status_autoapproved = config('constants.status.autoapproved');
        $status_declined = config('constants.status.declined');
        $status_autodeclined = config('constants.status.autodeclined');
        $status_active = config('constants.status.active');
        $status_open = config('constants.status.open');

        //durations
        $day_period = config('constants.duration.day');
        $week_period = config('constants.duration.week');
        $month_period = config('constants.duration.month');
        $year_period = config('constants.duration.year');

        //gl account types
        $mobile_loans_principal_gl_account_type = config('constants.gl_account_types.mobile_loans_principal');
        $mobile_loans_interest_gl_account_type = config('constants.gl_account_types.mobile_loans_interest');

        //contribution criteria
        $contribution_savings = config('constants.user_contribution_criteria.savings');
        $contribution_savings_shares = config('constants.user_contribution_criteria.savings_shares');
        $contribution_savings_registration = config('constants.user_contribution_criteria.savings_registration');
        $contribution_savings_registration_shares = config('constants.user_contribution_criteria.savings_registration_shares');
        $contribution_initial_loan_limit = config('constants.user_contribution_criteria.initial_loan_limit');

        //is loan product active?
        //check max loan limit
        /* if (($loan_product_status != 1)) {

            DB::rollback();
            $show_message = "Error, mobile loan is not available right now. Please try again later.";
            //$message["message"] = $show_message;
            log_this($show_message . "<br> Loan Application Id -" . $loan_application->id);
            //return show_json_error($message);
            throw new StoreResourceFailedException($show_message);

        } */

        //error messages
        $exceeded_max_loan_limit_error_msg = config('constants.error_messages.exceeded_max_loan_limit');

        $current_date = getCurrentDate(1);

        //get logged in user
        $user = auth()->user();

        $logged_user_id = $user->id;
        $logged_user_full_name = $user->first_name . ' ' . $user->last_name;

        

        /* if ($min_loan_limit > 0) {

            //check for errors
            //start check if user has requested a loan of a min $min_loan_limit
            if ($approved_loan_amt < $min_loan_limit) {
                $show_message = "Error, you cannot request for loan amount less than $min_loan_limit.";
                log_this($show_message . "<br> Loan Application Id -" . $loan_application->id);
                DB::rollback();
                throw new StoreResourceFailedException($show_message);
            }
            //end check if user has made max no of loan applications today

        } */

        //start check if user is active or not
        /* if ($loan_application->companyuser->status_id != 1) {

            $show_message = "Error, could not process loan. Your account is not yet active.";
            log_this($show_message . "<br> Loan Application Id -" . $loan_application->id);
            //dd($show_message);

            DB::rollback();
            throw new StoreResourceFailedException($show_message);
        } */
        //end check if user is active or not


        //are we in decline mode?
        if (($submit_btn == 'decline') && $admin_approval) {

            $decline_comments = "";
            //decline the loan application
            if (array_key_exists('comments', $attributes)) {
                $decline_comments = $attributes['comments'];
            }
            $declined_by = $logged_user_id;
            $declined_by_name = $logged_user_full_name;

            try {

                //start decline loan application
                $loan_application_decline = LoanApplication::where('id', $id)
                        ->update([
                            'loan_duration_cycle' => $loan_duration_cycle,
                            'loan_duration_period' => $loan_duration_period,
                            'status_id' => $status_declined,
                            'declined_at' => $current_date,
                            'declined_by' => $declined_by,
                            'declined_by_name' => $declined_by_name,
                            'comments' => $decline_comments
                        ]);
                //end decline loan application

                $response["message"] = "Loan application declined - " . $loan_application->id;

                //store audits
                storeLoanApplicationAudit($loan_application->id);

                $response = show_json_success($response);

            } catch(\Exception $e) {

                DB::rollback();
                //dd($e);
                $show_message = $e->getMessage();
                //return show_json_error($show_message);
                throw new StoreResourceFailedException($show_message);

            }


        } else {

            //start check if user already has a pending loan, exit if loan exist
            /* if (userHasPendingLoan($company_user_id, $company_id)) {
                DB::rollback();
                $company_data = Company::find($company_id);
                $company_name = $company_data->name;
                $show_message = "Error, you already have a loan with $company_name. ";
                //$show_message .= " You do not qualify for a new loan";
                $show_message .= " Please repay your current loan to qualify for a new loan";
                //$message["message"] = $show_message;
                log_this($show_message . "<br> Loan Application Id -" . $loan_application->id);

                throw new StoreResourceFailedException($show_message);
                //return show_json_error($message);
            } */
            //end check if user already has a pending loan, exit if loan exist

            //we are in admin approval mode or user generated loan approval process
            //save new record
            try {

                //check whether user has savings account in company
                $user_existing_account_data = Account::where('phone', $user_phone)
                        ->where('company_id', $company_id)
                        ->first();

                if ($user_existing_account_data) {

                    //check if loan application meets loan product settings
                    //if not met, skip
                    //if loan is less than set limit, proceed

                    if ($admin_approval) {

                        $approved_loan_amt = "";
                        $approved_by = $logged_user_id;
                        $approved_by_name = $logged_user_full_name;

                        //if loan application was approved by admin, proceed
                        if (array_key_exists('approved_term_id', $attributes)) {
                            $approved_term_id = $attributes['approved_term_id'];
                        }

                        if (array_key_exists('approved_term_value', $attributes)) {
                            $approved_term_value = $attributes['approved_term_value'];
                        }

                        if (array_key_exists('comments', $attributes)) {
                            $approval_comments = $attributes['comments'];
                        }

                        if (array_key_exists('approved_loan_amt', $attributes)) {
                            $approved_loan_amt = $attributes['approved_loan_amt'];
                        }

                    } else {

                        //user initiated process
                        $approved_by = '-1';
                        $approved_by_name = 'System';

                        //get user loan exposure limit,
                        //if none, assign default company user exposure limit
                        ///////////////////////////////////////////////////////////////////////
                        $new_exposure_limit = false;
                        $loan_exposure_limit_data = LoanExposureLimit::where('company_user_id', $company_user_id)->first();

                        //does the user have existing loan exposure limit data?
                        if ($loan_exposure_limit_data) {
                            //assign loan based on existing exposure limit
                            $user_loan_exposure_limit = $loan_exposure_limit_data->limit;
                        } else {
                            //use company default exposure limit
                            $user_loan_exposure_limit = $initial_exposure_limit;
                            $new_exposure_limit = true;
                        }
                        //////////////////////////////////////////////////////////////////////
                        //dd($loan_product_setting, $user_loan_exposure_limit);

                        $loan_calculation_percentage = $user_loan_exposure_limit; // + 100;

                        //START GET USER CONTRIBUTIONS
                        //start get dep acct summary payments data
                        /* $dep_acct_summary = DepositAccountSummary::where('company_user_id', $company_user_id)->first();
                        if ( $dep_acct_summary) {
                            $user_deposit_payments = $dep_acct_summary->ledger_balance;
                        } else {
                            $user_deposit_payments = 0;
                        } */
                        //end get dep acct summary payments data

                        //dd($user_deposit_payments);

                        //start get registration payments data
                        //$user_reg_payments = getUserRegistrationPayments($company_user_id);

                        //dd($user_reg_payments);

                        //start get user shares payments data
                        //$user_shares_payments = getUserSharesPayments($company_user_id);

                        //dd($user_deposit_payments, $user_reg_payments, $user_shares_payments);

                        //total user contributions
                        //$total_user_contributions = $user_deposit_payments + $user_reg_payments + $user_shares_payments;
                        //END GET USER CONTRIBUTIONS


                        //********* START CHECKS ***********/

                        //start check if loan application meets set loan limit condition
                        //get the loan criteria
                        //check max loan limit
                        /* if (($max_loan_limit > 0) && ($approved_loan_amt > $max_loan_limit)) {

                            DB::rollback();
                            $show_message = "Error, you can only request for a maximum loan of $max_loan_limit";
                            //dd($show_message);
                            //$message["message"] = $show_message;
                            log_this($show_message . "<br> Loan Application Id -" . $loan_application->id);
                            //return show_json_error($message);
                            throw new StoreResourceFailedException($show_message);

                        } */

                        //start check if user contributions meet set LOAN LIMIT requirements
                        /* if ($loan_limit_calculation_id == $contribution_savings) {
                            $user_set_loan_limit = $user_deposit_payments;
                        } elseif ($loan_limit_calculation_id == $contribution_savings_shares) {
                            $user_set_loan_limit = $user_deposit_payments + $user_shares_payments;
                        } elseif ($loan_limit_calculation_id == $contribution_savings_registration) {
                            $user_set_loan_limit = $user_deposit_payments + $user_reg_payments;
                        } elseif ($loan_limit_calculation_id == $contribution_savings_registration_shares) {
                            $user_set_loan_limit = $user_deposit_payments + $user_reg_payments + $user_shares_payments;
                        } elseif ($loan_limit_calculation_id == $contribution_initial_loan_limit) {
                            $user_set_loan_limit = $initial_loan_limit;
                        } */


                        //check if this is the first loan by user
                        //if so set the limit to initial_loan_limit
                        //$existing_loan_data = LoanAccount::where('company_user_id', $company_user_id)->first();

                        //get loan limits
                        /* if ($borrow_criteria == "contributions") {

                            //get allowed loan amt based on loan limits
                            $allowed_loan_amt = $user_set_loan_limit * ($loan_calculation_percentage/100);
                            //end check if loan application meets set loan limit condition

                            //if its the first loan and initial_loan_limit is set
                            if ((!$existing_loan_data) && ($initial_loan_limit > 0)) {
                                
                                //this is the first loan
                                $allowed_loan_amt = $initial_loan_limit;
                                
                            }

                        } else {
                        
                            //if its a subsequent loan, use the limit calc to get allowed loana amount
                            if ($existing_loan_data) {

                                $allowed_loan_amt = $user_set_loan_limit * ($loan_calculation_percentage/100);

                            } else {
                                
                                $allowed_loan_amt = $initial_loan_limit;
                                
                            }

                        } */

                        //dd($allowed_loan_amt);

                        //is the loan more than allowed?
                        /* if ($approved_loan_amt > $allowed_loan_amt) {

                            //error stop here
                            DB::rollback();
                            $show_message = "Error, you can only apply for a maximum loan of $allowed_loan_amt";
                            log_this($show_message . "<br> Loan Application Id -" . $loan_application->id);
                            throw new StoreResourceFailedException($show_message);

                        } */


                        /* if ($borrow_criteria == "contributions") {

                            if ($minimum_contributions > 0 && $minimum_contributions_condition_id) {

                                //check if user contributions meet set contribution requirements
                                if ($minimum_contributions_condition_id == $contribution_savings) {
                                    $user_contribution_limit = $user_deposit_payments;
                                } elseif ($minimum_contributions_condition_id == $contribution_savings_shares) {
                                    $user_contribution_limit = $user_deposit_payments + $user_shares_payments;
                                } elseif ($minimum_contributions_condition_id == $contribution_savings_registration) {
                                    $user_contribution_limit = $user_deposit_payments + $user_reg_payments;
                                } elseif ($minimum_contributions_condition_id == $contribution_savings_registration_shares) {
                                    $user_contribution_limit = $user_deposit_payments + $user_reg_payments + $user_shares_payments;
                                } 

                                //if user does not meet miinimum contributions requirement
                                if ($minimum_contributions > $user_contribution_limit) {

                                    // $error_message = $exceeded_max_loan_limit_error_msg;
                                    // log_this($error_message . "<br> Loan Application Id -" . $loan_application->id);
                                    // throw new StoreResourceFailedException($error_message);

                                    DB::rollback();
                                    $show_message = "Error, you must have minimum contributions of $minimum_contributions ";
                                    $show_message .= " to qualify for a loan. Your contributions = $user_contribution_limit";
                                    //dd($show_message);
                                    //$message["message"] = $show_message;
                                    log_this($show_message . "<br> Loan Application Id -" . $loan_application->id);
                                    //return show_json_error($message);
                                    throw new StoreResourceFailedException($show_message);

                                }

                            } else {

                                //check if user has made any contribution at least 1
                                if ($total_user_contributions < 1) {

                                    //$error_message = $exceeded_max_loan_limit_error_msg;
                                    DB::rollback();
                                    $show_message = "Error, you must have contributions to request a loan";
                                    //dd($show_message);
                                    //$message["message"] = $show_message;
                                    log_this($show_message . "<br> Loan Application Id -" . $loan_application->id);
                                    //return show_json_error($message);
                                    throw new StoreResourceFailedException($show_message);

                                }

                            }

                        } */

                        //dd($allowed_loan_amt);

                        //next condition

                        //********* END CHECKS ***********/

                    }


                    //////////////////////////////////////
                    //start create new loan account no
                    try{

                        //generate loan account number
                        //get max counter in loan_accounts table
                        $max_counter = DB::table('loan_accounts')->max('counter');

                        //get next number
                        $max_counter = $max_counter + 1;

                        //get new user account number - get max account no
                        $mobile_loan_account_no = generate_account_number($loan_application->company_id, 01, $max_counter,  $mobile_loan_product_id);

                    } catch(\Exception $e) {

                        DB::rollback();
                        $message_text = $e->getMessage();
                        //dd($message_text);
                        log_this($message_text);
                        $show_message = "Error processing loan. Please try again later.";
                        //$message["message"] = $show_message;
                        //return show_json_error($message);
                        throw new StoreResourceFailedException($show_message);

                    }

                    //dd($max_counter);


                    //CALCULATE LOAN INTEREST
                    //get interest amt
                    if ($interest_type == 'percentage') {
                        $total_interest = $approved_loan_amt * ($interest_amount / 100);
                    } else {
                        $total_interest = $interest_amount;
                    }

                    //get total loan plus interest
                    $total_loan_plus_interest = $approved_loan_amt + $total_interest;


                    //start create new loan entry
                    try {

                        //start create new loan entry
                        $mobile_loan_account_entry = new LoanAccount();

                        $mobile_loan_acct_entry_attributes['account_no'] = $mobile_loan_account_no;
                        $mobile_loan_acct_entry_attributes['loan_application_id'] = $id;
                        $mobile_loan_acct_entry_attributes['counter'] = $max_counter;
                        $mobile_loan_acct_entry_attributes['ref_account_id'] = $user_existing_account_data->id;
                        $mobile_loan_acct_entry_attributes['account_name'] = $loan_application->user->first_name . ' ' . $loan_application->user->last_name;
                        $mobile_loan_acct_entry_attributes['company_product_id'] = $loan_application->company_product_id;
                        $mobile_loan_acct_entry_attributes['group_id'] = $loan_application->group_id;
                        $mobile_loan_acct_entry_attributes['company_id'] = $loan_application->company_id;
                        $mobile_loan_acct_entry_attributes['user_id'] = $loan_application->user_id;
                        $mobile_loan_acct_entry_attributes['company_user_id'] = $loan_application->company_user_id;
                        $mobile_loan_acct_entry_attributes['currency_id'] = $loan_application->currency_id;
                        $mobile_loan_acct_entry_attributes['loan_amt'] = -$approved_loan_amt;
                        $mobile_loan_acct_entry_attributes['loan_amt_calc'] = $approved_loan_amt;
                        $mobile_loan_acct_entry_attributes['repayment_amt'] = -$total_loan_plus_interest;
                        $mobile_loan_acct_entry_attributes['repayment_amt_calc'] = $total_loan_plus_interest;
                        $mobile_loan_acct_entry_attributes['loan_bal'] = -$total_loan_plus_interest;
                        $mobile_loan_acct_entry_attributes['loan_bal_calc'] = $total_loan_plus_interest;
                        $mobile_loan_acct_entry_attributes['status_id'] = $status_open;
                        $mobile_loan_acct_entry_attributes['term_id'] = $approved_term_id;
                        $mobile_loan_acct_entry_attributes['term_value'] = $approved_term_value;

                        $new_mobile_loan_account_entry = $mobile_loan_account_entry::create($mobile_loan_acct_entry_attributes);
                        //end create new loan entry

                    } catch(\Exception $e) {

                        DB::rollback();
                        $message = $e->getMessage();
                        //dd($message);
                        log_this($message);
                        $show_message_text = "Error processing loan. Please try again later.";
                        $show_message["message"] = $show_message_text;
                        //return show_json_error($show_message);
                        throw new StoreResourceFailedException($show_message_text);

                    }

                    //dump("check here 1");

                    //*************************************************************//

                    //get no of repayment cycles
                    //get single repayment as fraction of total instalment

                    $verified_instalment_period = "";
                    $verified_instalment_cycle = "";

                    if ($interest_amount > 0) {

                        if ($loan_instalment_period) {

                            $verified_instalment_period = $loan_instalment_period;

                            if ($loan_instalment_cycle == $day_period) {
                                $verified_instalment_cycle = "day";
                            } else if ($loan_instalment_cycle == $week_period) {
                                $verified_instalment_cycle = "week";
                            } else if ($loan_instalment_cycle == $month_period) {
                                $verified_instalment_cycle = "month";
                            } else if ($loan_instalment_cycle == $year_period) {
                                $verified_instalment_cycle = "year";
                            }

                        }

                    }

                    //calculate repayment amounts
                    $repayment_amounts = json_decode(get_repayment_amounts($total_loan_plus_interest, $verified_instalment_period));

                    //dd("rep here", $repayment_amounts);

                    //get loan repayment dates from today
                    //get current date
                    $current_date = getCurrentDateObj();

                    //array to keep repayment schedule
                    $repayment_schedule_data = array();

                    //set dates
                    $this_repayment_dates = array();

                    //dump($verified_instalment_cycle);

                    //loop thru and set repayment dates
                    $repayment_amounts_size = count($repayment_amounts);
                    for ($i=0; $i<$repayment_amounts_size; $i++) {

                        if (array_key_exists($i, $repayment_amounts)) {

                            //get repayment amount from repayment_amounts array index
                            $repayment_amount = $repayment_amounts[$i];

                            //get new repayment date
                            switch ($verified_instalment_cycle) {
                                case "day":
                                    $repayment_date = $current_date->addDay();
                                    break;
                                case "week":
                                    $repayment_date = $current_date->addWeek();
                                    break;
                                case "month":
                                    $repayment_date = $current_date->addMonth();
                                    break;
                                case "year":
                                    $repayment_date = $current_date->addYear();
                                    break;
                                default:
                                    $repayment_date = $current_date->addMonth();
                                    break;
                            }

                            //dump("repayment_date", $repayment_date);

                            //get first repayment
                            if ($i == 0) {
                                $first_repayment_date = $repayment_date->toDateTimeString();
                            }

                            //get last repayment
                            if ($i == ($repayment_amounts_size - 1)) {
                                $last_repayment_date = $repayment_date->toDateTimeString();
                            }

                            //start create new loan repayment schedule entry
                            try {

                                $loan_repayment_schedule_entry = new LoanRepaymentSchedule();

                                $loan_repayment_schedule_attributes['loan_account_id'] = $new_mobile_loan_account_entry->id;
                                $loan_repayment_schedule_attributes['amount'] = $repayment_amount;
                                $loan_repayment_schedule_attributes['company_id'] = $loan_application->company_id;
                                $loan_repayment_schedule_attributes['user_id'] = $loan_application->user_id;
                                $loan_repayment_schedule_attributes['company_user_id'] = $loan_application->company_user_id;
                                $loan_repayment_schedule_attributes['status_id'] = $status_open;
                                $loan_repayment_schedule_attributes['repayment_at'] = $repayment_date;

                                $new_loan_repayment_schedule_entry = $loan_repayment_schedule_entry::create($loan_repayment_schedule_attributes);

                            } catch (\Exception $e) {

                                DB::rollback();
                                $message_text = "Error creating loan repayment schedule - " . $e->getMessage();
                                //dd($message_text);
                                log_this($message_text);
                                $show_message = "Error processing loan. Please try again later.";
                                //$show_message["message"] = $show_message;
                                //return show_json_error($show_message);
                                throw new StoreResourceFailedException($show_message);

                            }
                            //end create new loan repayment schedule entry

                            //create single repayment array item
                            $this_repayment = array();
                            $this_repayment['date'] = $repayment_date->toDateString();
                            $this_repayment['amount'] = $repayment_amount;

                            //add to main repayment_schedule_data array
                            array_push($repayment_schedule_data, $this_repayment);

                            //end create new loan repayment schedule entry

                        }

                    }
                    //dd($first_repayment_date, $last_repayment_date, $this_repayment_dates);

                    //return repayment_schedule_data in response
                    $response['repayment_schedule'] = $repayment_schedule_data;

                    //*************************************************************//

                    //update loan account with start_at and maturity_at dates
                    try {

                        $new_mobile_loan_account_entry
                            ->update([
                                'start_at' => $first_repayment_date,
                                'maturity_at' => $last_repayment_date,
                                'original_maturity_at' => $last_repayment_date
                            ]);

                    } catch(\Exception $e) {

                        DB::rollback();
                        $message_text = "Error getting  mobile_loans_principal_gl_account_no - " . $e->getMessage();
                        //dd($message_text);
                        log_this($message_text);
                        $show_message = "Error processing loan. Please try again later.";
                        //$message["message"] = $show_message;
                        //return show_json_error($message);
                        throw new StoreResourceFailedException($show_message);

                    }


                    //START SAVE TO MOBILE LOAN PRINCIPAL GL ACCOUNT
                    try {

                        //start get mobile loan principal gl account
                        $mobile_loans_principal_gl_account_no = get_gl_account_number($mobile_loans_principal_gl_account_type, $company_id);
                        //end get mobile loan principal gl account

                    } catch(\Exception $e) {

                        DB::rollback();
                        $message_text = "Error getting  mobile_loans_principal_gl_account_no - " . $e->getMessage();
                        //dd($message_text);
                        log_this($message_text);
                        $show_message = "Error processing loan. Please try again later.";
                        //$message["message"] = $show_message;
                        //return show_json_error($message);
                        throw new StoreResourceFailedException($show_message);

                    }


                    try {

                        //start save mobile loan principal gl account entry
                        $payment_id = NULL;
                        $mob_approved_loan_amount = $approved_loan_amt;
                        $dr_cr_ind = "CR";
                        $tran_ref_txt = "Loan approval  loan_appl_id - " . $loan_application->id;
                        $tran_desc = "Loan acct id - " . $new_mobile_loan_account_entry->id . " Loan acct name - " . $new_mobile_loan_account_entry->account_name;
                        $principal_summary_sign = "pos";
                        $principal_hist_sign = "pos";
                        $principal_summary_action = "pos";
                                            
                        createGlAccountEntry($payment_id, $mob_approved_loan_amount, $mobile_loans_principal_gl_account_type,
                                             $company_id, $user_phone, $dr_cr_ind, $tran_ref_txt, $tran_desc, $principal_summary_sign, 
                                             $principal_hist_sign, $principal_summary_action);
                        //end save mobile loan principal gl account entry

                    } catch(\Exception $e) {

                        DB::rollback();
                        $message_text = "Error creating  mobile_loans_principal_gl_account entry - " . $e->getMessage();
                        //dd($message_text);
                        log_this($message_text);
                        $show_message = "Error processing loan. Please try again later.";
                        //$message["message"] = $show_message;
                        //return show_json_error($message);
                        throw new StoreResourceFailedException($show_message);

                    }
                    //END SAVE TO MOBILE LOAN PRINCIPAL GL ACCOUNT




                    //START SAVE TO MOBILE LOAN INTEREST GL ACCOUNT
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
                        $show_message = "Error processing loan. Please try again later.";
                        //$message["message"] = $show_message;
                        //return show_json_error($message);
                        throw new StoreResourceFailedException($show_message);

                    }


                    try {

                        //start save mobile loan interest gl account entry
                        $dr_cr_ind = "CR";
                        $tran_ref_txt = "Loan approval  loan_appl_id - " . $loan_application->id;
                        $tran_desc = "Loan acct id - " . $new_mobile_loan_account_entry->id . " Loan acct name - " . $new_mobile_loan_account_entry->account_name;
                        $int_summary_sign = "pos";
                        $int_hist_sign = "pos";
                        $int_summary_action = "pos";
                        $payment_id = NULL;
                        $mob_loan_interest = $total_interest;
                        createGlAccountEntry($payment_id, $mob_loan_interest, $mobile_loans_interest_gl_account_type,
                                             $company_id, $user_phone, $dr_cr_ind,  $tran_ref_txt, $tran_desc, $int_summary_sign, 
                                             $int_hist_sign, $int_summary_action);
                        //end save mobile loan interest gl account entry

                    } catch(\Exception $e) {

                        DB::rollback();
                        $message_text = "Error creating  mobile_loans_interest_gl_account entry - " . $e->getMessage();
                        //dd($message_text);
                        log_this($message_text);
                        $show_message = "Error processing loan. Please try again later.";
                        //$message["message"] = $show_message;
                        //return show_json_error($message);
                        throw new StoreResourceFailedException($show_message);

                    }
                    //END SAVE TO MOBILE LOAN INTEREST GL ACCOUNT


                    //start activate/ approve loan application
                    try {

                        $loan_application_approval = LoanApplication::find($id);
                        //dd($loan_application_approval);

                        if ($admin_approval) {
                            $the_status = $status_approved;
                        } else {
                            $the_status = $status_autoapproved;
                            $approval_comments = "Loan Successfully Approved";
                        }

                        $loan_application_approval->approved_term_id = $approved_term_id;
                        $loan_application_approval->approved_term_value = $approved_term_value;
                        $loan_application_approval->status_id = $the_status;
                        $loan_application_approval->approved_at = getCurrentDate(1);
                        $loan_application_approval->approved_by = $approved_by;
                        $loan_application_approval->approved_by_name = $approved_by_name;
                        $loan_application_approval->approved_loan_amt = $approved_loan_amt;
                        if ($approval_comments) {
                            $loan_application_approval->comments = $approval_comments;
                        }

                        $loan_application_approval->save();

                        //store audits
                        storeLoanApplicationAudit($id);


                    } catch(\Exception $e) {

                        DB::rollback();
                        $message_text = "Error updating  loan application entry - " . $e->getMessage();
                        //dd($message_text);
                        log_this($message_text);
                        $show_message = "Error processing loan. Please try again later.";
                        //$message["message"] = $show_message;
                        //return show_json_error($message);
                        throw new StoreResourceFailedException($show_message);

                    }
                    //end activate/ approve loan application
                    //dd("stop here");


                    //start if new exposure limit, create new user exposure limit
                    if ($new_exposure_limit) {

                        //start create new loan user exposure limit
                        try {

                            $loan_exposure_limit_entry = new LoanExposureLimit();

                            $loan_exposure_limit_attributes['limit'] = $user_loan_exposure_limit;
                            $loan_exposure_limit_attributes['company_id'] = $loan_application->company_id;
                            $loan_exposure_limit_attributes['user_id'] = $loan_application->user_id;
                            $loan_exposure_limit_attributes['company_user_id'] = $loan_application->company_user_id;

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
                        //end create new loan user exposure limit

                        //start create new loan user exposure limit details
                        try {

                            $loan_exposure_limit_detail_entry = new LoanExposureLimitsDetail();

                            //$loan_exposure_limit_detail_attributes['limit'] = $user_loan_exposure_limit;
                            $loan_exposure_limit_detail_attributes['current_limit'] = $user_loan_exposure_limit;
                            $loan_exposure_limit_detail_attributes['company_id'] = $loan_application->company_id;
                            $loan_exposure_limit_detail_attributes['user_id'] = $loan_application->user_id;
                            $loan_exposure_limit_detail_attributes['comments'] = "Initial exposure limit";
                            $loan_exposure_limit_detail_attributes['company_user_id'] = $loan_application->company_user_id;
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
                        //end create new loan user exposure limit details

                    }
                    //end if new exposure limit, create new user exposure limit

                    $response["message"] = "Successful loan application.";
                    $response = show_json_success($response);

                } else {

                    //user has no account
                    DB::rollback();
                    $message_text = "Error user has no savings account created - " . $e->getMessage();
                    log_this($message_text);
                    $show_message = "Error processing loan. Please try again later.";
                    throw new StoreResourceFailedException($show_message);

                }

            } catch(\Exception $e) {

                DB::rollback();
                $show_message = $e->getMessage();
                //dd($show_message);
                log_this($show_message);
                //$message["message"] = $show_message;
                //return show_json_error($message);
                throw new StoreResourceFailedException($show_message);

            }

            //dd("stop here too");

        }

        DB::commit();

        return $response;

    }

}