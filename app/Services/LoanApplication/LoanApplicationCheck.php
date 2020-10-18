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

class LoanApplicationCheck
{

    public function approveItem($id, $attributes=array()) {

        DB::beginTransaction();

            $message = array();

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

            //get user details
            $company_user_data = CompanyUser::find($company_user_id);

            if ($registration_amount >0 && $company_user_data->registration_paid == 0) {

                //user has not paid registration fees, show user the message
                $show_message = "You are not fully registered. Please pay registration fee of $registration_amount to proceed.";
                log_this($show_message . "<br> Loan Application Id -" . $loan_application->id);
                DB::rollback();
                throw new StoreResourceFailedException($show_message);

            }

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
                $one_month_limit = $loan_product_setting->one_month_limit;
                $one_to_three_month_limit = $loan_product_setting->one_to_three_month_limit;
                $three_to_six_month_limit = $loan_product_setting->three_to_six_month_limit;
                $above_six_month_limit = $loan_product_setting->above_six_month_limit;
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
            $status_waiting = config('constants.status.waiting');
            $status_pending = config('constants.status.pending');

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


            //START :: save current user contributions and exposure limit to loan application

            //start get user loan exposure limit,
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
            //end get user loan exposure limit

            //START GET USER CONTRIBUTIONS
            //start get dep acct summary payments data
            try {
                $dep_acct_summary = DepositAccountSummary::where('company_user_id', $company_user_id)->first();
                if ( $dep_acct_summary) {
                    $user_deposit_payments = $dep_acct_summary->ledger_balance;
                } else {
                    $user_deposit_payments = 0;
                }
            } catch(\Exception $e) {
                DB::rollback();
                //dd($e);
                $show_message = "Error processing loan right now. Please try again later.";
                log_this($show_message . "<br> No deposit account summary record found. Loan Application Id -" . $loan_application->id);
                throw new StoreResourceFailedException($show_message);
            }
            //end get dep acct summary payments data

            //start get registration payments data
            $user_reg_payments = getUserRegistrationPayments($company_user_id);

            //start get user shares payments data
            $user_shares_payments = getUserSharesPayments($company_user_id);

            //total user contributions
            $total_user_contributions = $user_deposit_payments + $user_reg_payments + $user_shares_payments;
            //END GET USER CONTRIBUTIONS

            //start get user shares payments data
            $user_set_loan_limit = getUserSetLoanLimit($loan_limit_calculation_id, $user_deposit_payments,
                                                        $user_reg_payments, $user_shares_payments, $initial_loan_limit);

            //dd($user_set_loan_limit, $user_set_loan_limit_desc);
            //END :: save current user contributions and exposure limit to loan application

            //is loan product active?
            //check max loan limit
            if (($loan_product_status != $status_active)) {

                DB::rollback();
                $show_message = "Mobile loan is not available right now. Please try again later.";
                log_this($show_message . "<br> Loan Application Id -" . $loan_application->id);
                throw new StoreResourceFailedException($show_message);

            }


            //check if user has received max loans for today
            if ($max_loan_applications_per_day > 0) {

                //check errors
                //get no of approved loans today
                $no_loan_applications = LoanApplication::where('company_user_id', $company_user_id)
                                                        ->where(function($q) use ($status_approved, $status_waiting){
                                                            $q->where('status_id', '=', $status_approved);
                                                            $q->orWhere('status_id', '=', $status_waiting);
                                                        })
                                                        ->whereDate('created_at', Carbon::today())
                                                        ->count('id');
                    
                //if user has already got enough loans today, throw error
                if ($no_loan_applications >= $max_loan_applications_per_day) {
                    $show_message = "Error, you cannot get more than $max_loan_applications_per_day loans per day. Try again tomorrow.";
                    log_this($show_message . "<br> company_user_id -" . $company_user_id);
                    throw new StoreResourceFailedException($show_message);
                }
                //end check if user has got max no of loans today

            }


            //error messages
            $exceeded_max_loan_limit_error_msg = config('constants.error_messages.exceeded_max_loan_limit');

            $current_date = getCurrentDate(1);

            //get logged in user
            $user = auth()->user();
            $logged_user_id = $user->id;
            $logged_user_full_name = $user->first_name . ' ' . $user->last_name;

            $admin_approval = "";
            $submit_btn = "";
            $approval_comments = "";

            if (array_key_exists('admin_approval', $attributes)) {
                $admin_approval = $attributes['admin_approval'];
            }

            if (array_key_exists('submit_btn', $attributes)) {
                $submit_btn = $attributes['submit_btn'];
            }


            if ($min_loan_limit > 0) {

                //check for errors
                //start check if user has requested a loan of a min $min_loan_limit
                if ($approved_loan_amt < $min_loan_limit) {
                    $show_message = "Error, you cannot request for loan amount less than $min_loan_limit.";
                    log_this($show_message . "<br> Loan Application Id -" . $loan_application->id);
                    DB::rollback();
                    throw new StoreResourceFailedException($show_message);
                }
                //end check if user has made max no of loan applications today

            }

            //start check if user is active or not
            if ($loan_application->companyuser->status_id != $status_active) {

                $show_message = "Error, could not process loan. Your account is not yet active.";
                log_this($show_message . "<br> Loan Application Id -" . $loan_application->id);
                DB::rollback();
                throw new StoreResourceFailedException($show_message);

            }
            //end check if user is active or not

            //get company data
            $company_data = Company::find($company_id);

            //start check if user already has a pending loan, exit if loan exist
            if (userHasPendingLoan($company_user_id, $company_id)) {
                DB::rollback();
                $company_name = $company_data->name;
                $show_message = "Error, you already have a loan with $company_name. ";
                //$show_message .= " You do not qualify for a new loan";
                $show_message .= " Please repay your current loan to qualify for a new loan";
                //$message["message"] = $show_message;
                log_this($show_message . "<br> Loan Application Id -" . $loan_application->id);
                throw new StoreResourceFailedException($show_message);
                //return show_json_error($message);
            }
            //end check if user already has a pending loan, exit if loan exist

            //start check if user already has a pending loan application, exit if so
            if (userHasPendingLoanApplication($company_user_id, $company_id, $loan_application->id)) {
                DB::rollback();
                $company_name = $company_data->name;
                $show_message = "Error, you already have a pending loan application with $company_name. ";
                $show_message .= " Please wait for it to be processed";
                //$message["message"] = $show_message;
                log_this($show_message . "<br> Loan Application Id -" . $loan_application->id);

                throw new StoreResourceFailedException($show_message);
                //return show_json_error($message);
            }
            //end check if user already has a pending loan application, exit if so

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

                        /////////////////////////////////////////////////////////////////////
                        $loan_calculation_percentage = $user_loan_exposure_limit; 
                        /////////////////////////////////////////////////////////////////////


                        //********* START CHECKS ***********/

                        //start check if loan application meets set loan limit condition
                        //get the loan criteria
                        //check max loan limit
                        if (($max_loan_limit > 0) && ($approved_loan_amt > $max_loan_limit)) {

                            DB::rollback();
                            $max_loan_limit_fmt = formatCurrency($max_loan_limit);
                            $show_message = "Error, you can only request for a maximum loan of $max_loan_limit_fmt";
                            log_this($show_message . "<br> Loan Application Id -" . $loan_application->id);
                            throw new StoreResourceFailedException($show_message);

                        }

                        //dd($user_set_loan_limit);

                        //get user allowed loan amount
                        $allowed_loan_amt_data = getAllowedLoanAmount($company_user_id, $borrow_criteria, $loan_calculation_percentage, $user_set_loan_limit,
                        $one_month_limit, $one_to_three_month_limit, $three_to_six_month_limit, $above_six_month_limit);
                        $allowed_loan_amt_data = json_decode($allowed_loan_amt_data);

                        //get the allowed loan amount for user
                        $allowed_loan_amt = $allowed_loan_amt_data->allowed_loan_amt;
                        $member_age_limit = $allowed_loan_amt_data->member_age_limit;
                        $member_age_limit_amt = $allowed_loan_amt_data->member_age_limit_amt;
                        $membership_date = $allowed_loan_amt_data->membership_date;

                        //start update loan application

                        //dd($allowed_loan_amt, $member_age_limit, $member_age_limit_amt, $membership_date);


                        //dd($allowed_loan_amt); 

                        //is the loan more than allowed?
                        if ($approved_loan_amt > $allowed_loan_amt) {

                            //error stop here
                            DB::rollback();
                            $allowed_loan_amt_fmt = formatCurrency($allowed_loan_amt);
                            $show_message = "Error, you can only apply for a maximum loan of $allowed_loan_amt_fmt";
                            log_this($show_message . "<br> Loan Application Id -" . $loan_application->id);
                            throw new StoreResourceFailedException($show_message);

                        }
                        

                        if ($borrow_criteria == "contributions") {

                            if (($minimum_contributions > 0) && $minimum_contributions_condition_id) {

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

                                    DB::rollback();
                                    $minimum_contributions_fmt = formatCurrency($minimum_contributions);
                                    $user_contribution_limit_fmt = formatCurrency($user_contribution_limit);
                                    $show_message = "Error, you must have minimum contributions of $minimum_contributions_fmt ";
                                    $show_message .= " to qualify for a loan. Your contributions = $user_contribution_limit_fmt";
                                    log_this($show_message . "<br> Loan Application Id -" . $loan_application->id);
                                    throw new StoreResourceFailedException($show_message);

                                }

                            } else {

                                //check if user has made any contribution at least 1
                                if ($total_user_contributions < 1) {

                                    DB::rollback();
                                    $show_message = "Error, you must have contributions to request a loan";
                                    log_this($show_message . "<br> Loan Application Id -" . $loan_application->id);
                                    throw new StoreResourceFailedException($show_message);

                                }

                            }

                        }

                        //********* END CHECKS ***********/

                    }


                    //start activate/ approve loan application
                    try {

                        $loan_application_approval = LoanApplication::find($id);

                        //$loan_application_approval->status_id = $status_waiting;
                        $loan_application_approval->status_id = $status_pending;
                        //$loan_application_approval->comments = "Waiting for Mpesa disbursement";
                        $loan_application_approval->comments = "Pending approval";

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


                    //start get company mpesa shortcode
                    $mpesa_shortcode_data = getMainCompanyMpesaShortcode($company_id);
                    //dd($mpesa_shortcode_data);
                    $mpesa_shortcode_data = json_decode($mpesa_shortcode_data);
                    $mpesa_shortcode_data = $mpesa_shortcode_data->data;
                    $shortcode_number = $mpesa_shortcode_data->shortcode_number;
                    //end get company mpesa shortcode

                    //dd($mpesa_shortcode_data);

                    try {

                        //create mpesab2c request
                        $amount = $approved_loan_amt;
                        $phone = $user_phone;
                        $shortcode = $shortcode_number;
                        $tran_ref_txt = "Loan Application - " . $loan_application->id;
                        $src_id = $loan_application->id;
                        $app_name = "snb"; 
                        $remote_result = sendDataToMpesaB2c($shortcode, $phone, $amount, $tran_ref_txt, $company_id, $src_id, $app_name);

                        //get status code
                        //dd($remote_result);
                        $remote_result = json_decode($remote_result);

                        if ($remote_result) {

                            $response_result_message = $remote_result->message;

                            $loan_application_approval = LoanApplication::find($loan_application->id);

                            if (!$remote_result->error) {
                                
                                //based on result, update loan application status
                                $loan_application_approval->status_id = $status_waiting;
                                $loan_application_approval->comments = "Waiting for Mpesa disbursement";
                                $loan_application_approval->save();

                                //store audits
                                storeLoanApplicationAudit($loan_application->id);

                            } else {

                                //based on result, update loan application status
                                $loan_application_approval->status_id = $status_autodeclined;
                                $loan_application_approval->comments = "Loan application declined - " . $response_result_message;
                                $loan_application_approval->save();

                                $show_message = "Error processing loan. Please try again later.";
                                throw new StoreResourceFailedException($show_message);

                            }

                        }

                    } catch(\Exception $e) {

                        //dd($e);
                        DB::rollback();
                        $message_text = "Error creating mpesa b2c request - Loan Application - $id - " . $e->getMessage();
                        log_this($message_text);
                        $show_message = "Error processing loan. Please try again later.";
                        throw new StoreResourceFailedException($show_message);

                    }

                    $response["message"] = "Successful loan application. Please wait for it to be processed.";
                    $response = show_json_success($response);

                } else {

                    //user has no account
                    DB::rollback();
                    $message_text = "Error user has no savings account created - " . $e->getMessage();
                    //dd($message_text);
                    log_this($message_text);
                    $show_message = "Error processing loan. Please try again later.";
                    //$message["message"] = $show_message;
                    //return show_json_error($message);
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

        DB::commit();


        return $response;


    }

}