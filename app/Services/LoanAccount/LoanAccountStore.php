<?php

namespace App\Services\LoanAccount;

use App\Entities\LoanApplication;
use App\Entities\Company;
use App\Entities\DepositAccount;
use App\Entities\DepositAccountSummary;
use App\Entities\LoanExposureLimit;
use App\Entities\LoanProductSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoanAccountStore
{

    public function createItem($attributes) {

        //dd($attributes);

        $queue_declined_application = false;
        $loan_application_failed = false;
        $show_error = false;

        $current_date = getCurrentDate(1);

        $status_autodeclined = config('constants.status.autodeclined');
        $status_pending = config('constants.status.pending');
        $mobile_loan_product_id = config('constants.account_settings.mobile_loan_product_id');

        $deposit_account_id = "";
        $company_product_id = "";
        $company_user_id = "";
        $company_id = "";
        $applied_at = "";
        $loan_amt = "";

        if (array_key_exists('deposit_account_id', $attributes)) {
            $deposit_account_id = $attributes['deposit_account_id'];
        }
        if (array_key_exists('company_product_id', $attributes)) {
            $company_product_id = $attributes['company_product_id'];
        }
        if (array_key_exists('applied_at', $attributes)) {
            $applied_at = $attributes['applied_at'];
        }
        if (array_key_exists('company_user_id', $attributes)) {
            $company_user_id = $attributes['company_user_id'];
        }
        if (array_key_exists('company_id', $attributes)) {
            $company_id = $attributes['company_id'];
        }
        if (array_key_exists('loan_amt', $attributes)) {
            $loan_amt = $attributes['loan_amt'];
        }

        //dd($company_product_id);

        //get company_product_data
        if (!$company_product_id) {
            $company_product_data = CompanyProduct::where('product_id', $mobile_loan_product_id)
                                ->where('company_id', $company_id)
                                ->first();
            $company_product_id = $company_product_data->id;
        } 
        //dd($company_product_id, $mobile_loan_product_id);

        //check if user has pending loans
        //get deposit account details
        if ($deposit_account_id) {
            $deposit_account = DepositAccount::find($deposit_account_id);
        } else {
            $deposit_account = DepositAccount::where('company_user_id', $company_user_id)->first();
        }

        //no deposit account found....
        if (!$deposit_account) {
            $company_data = Company::find($company_id);
            $message['message'] = "An error occured. Please contact " . $company_data->name . " admin";
            //dd($message);
            //log_this($message);
            return show_json_error($message);
        }

        //set new attributes
        $company_user_id = $deposit_account->company_user_id;
        $user_id = $deposit_account->user_id;
        $account_no = $deposit_account->account_no;
        $deposit_account_id = $deposit_account->id;
        //dd($company_user_id);

        $attributes['company_user_id'] = $company_user_id;
        $attributes['user_id'] = $user_id;
        $attributes['deposit_account_no'] = $account_no;
        $attributes['deposit_account_id'] = $deposit_account_id;
        $attributes['status_id'] = $status_pending;

        //dd($attributes, $deposit_account);

        //get the company loan product settings
        $loan_product_setting = LoanProductSetting::where('company_product_id', $company_product_id)
                                ->first();

        $loans_exceeding_limit = $loan_product_setting->loans_exceeding_limit;
        $loan_approval_method = $loan_product_setting->loan_approval_method;
        $max_loan_applications_per_day = $loan_product_setting->max_loan_applications_per_day;
        $min_loan_limit = $loan_product_setting->min_loan_limit;
        $initial_loan_limit = $loan_product_setting->initial_loan_limit;
        $loan_limit_calculation_id = $loan_product_setting->loan_limit_calculation_id;
        $initial_exposure_limit = $loan_product_setting->initial_exposure_limit;
        $one_month_limit = $loan_product_setting->one_month_limit;
        $one_to_three_month_limit = $loan_product_setting->one_to_three_month_limit;
        $three_to_six_month_limit = $loan_product_setting->three_to_six_month_limit;
        $above_six_month_limit = $loan_product_setting->above_six_month_limit;
        $borrow_criteria = $loan_product_setting->borrow_criteria;

        $attributes['prime_limit_amt'] = $loan_product_setting->max_loan_limit;
        $attributes['interest_method'] = $loan_product_setting->interest_method;
        $attributes['interest_amount'] = $loan_product_setting->interest_amount;
        $attributes['interest_type'] = $loan_product_setting->interest_type;
        $attributes['term_id'] = $loan_product_setting->loan_instalment_cycle;
        $attributes['term_value'] = $loan_product_setting->loan_instalment_period;
        if (!$applied_at){
            $attributes['applied_at'] = getCurrentDate(1);
        }

        //dd($loan_product_setting, $attributes); 

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
        }
        //end get user loan exposure limit

        //START GET USER CONTRIBUTIONS
        //start get dep acct summary payments data
        $user_deposit_payments = 0;
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
            $message = "Error processing loan right now. Please try again later.";
            log_this($message . "<br> No deposit account summary record found. Loan Appl store.");
            $show_message['message'] = $message;
            return show_json_error($show_message);
        }
        //end get dep acct summary payments data

        $user_deposit_payments_fmt = formatCurrency($user_deposit_payments);

        $initial_loan_limit_fmt = formatCurrency($initial_loan_limit);

        //start get registration payments data
        $user_reg_payments = getUserRegistrationPayments($company_user_id);
        $user_reg_payments_fmt = formatCurrency($user_reg_payments);

        //start get user shares payments data
        $user_shares_payments = getUserSharesPayments($company_user_id);
        $user_shares_payments_fmt = formatCurrency($user_shares_payments);

        //total user contributions
        $total_user_contributions = $user_deposit_payments + $user_reg_payments + $user_shares_payments;
        $total_user_contributions_fmt = formatCurrency($total_user_contributions);
        //END GET USER CONTRIBUTIONS


        //start get user loan limit data
        $user_set_loan_limit = getUserSetLoanLimit($loan_limit_calculation_id, $user_deposit_payments,
                                                   $user_reg_payments, $user_shares_payments, $initial_loan_limit);
                                                    
        /////////////////////////////////////////////////////////////////////
        $loan_calculation_percentage = $user_loan_exposure_limit; 
        /////////////////////////////////////////////////////////////////////

        //start get user allowed loan amount
        $allowed_loan_amt_data = getAllowedLoanAmount($company_user_id, $borrow_criteria, $loan_calculation_percentage, 
                                                      $user_set_loan_limit, $one_month_limit, $one_to_three_month_limit,
                                                      $three_to_six_month_limit, $above_six_month_limit, $initial_loan_limit);
        $allowed_loan_amt_data = json_decode($allowed_loan_amt_data);
        //dd($allowed_loan_amt_data);

        //get the allowed loan amount for user
        $allowed_loan_amt = $allowed_loan_amt_data->allowed_loan_amt;
        $member_age_limit = $allowed_loan_amt_data->member_age_limit;
        $member_age_limit_amt = $allowed_loan_amt_data->member_age_limit_amt;
        $membership_date = $allowed_loan_amt_data->membership_date;
        //end get user allowed loan amount

        if ($member_age_limit) {
            $attributes['membership_age_limit'] = $member_age_limit;
        }

        if ($member_age_limit_amt) {
            $attributes['membership_age_limit_amt'] = $member_age_limit_amt;
        }

        if ($allowed_loan_amt) {
            $attributes['allowed_loan_amt'] = $allowed_loan_amt;
        }

        //start check if user contributions meet set LOAN LIMIT requirements
        if ($loan_limit_calculation_id == $contribution_savings) {

            $user_set_loan_limit = $user_deposit_payments;
            $user_set_loan_limit_desc = "user deposits - $user_deposit_payments_fmt";

        } elseif ($loan_limit_calculation_id == $contribution_savings_shares) {

            $user_set_loan_limit = $user_deposit_payments + $user_shares_payments;
            $user_set_loan_limit_desc = "user deposits - $user_deposit_payments_fmt,";
            $user_set_loan_limit_desc .= " user shares - $user_shares_payments_fmt";

        } elseif ($loan_limit_calculation_id == $contribution_savings_registration) {

            $user_set_loan_limit = $user_deposit_payments + $user_reg_payments;
            $user_set_loan_limit_desc = "user deposits - $user_deposit_payments_fmt,";
            $user_set_loan_limit_desc .= " user registration - $user_reg_payments_fmt";

        } elseif ($loan_limit_calculation_id == $contribution_savings_registration_shares) {

            $user_set_loan_limit = $user_deposit_payments + $user_reg_payments + $user_shares_payments;
            $user_set_loan_limit_desc = "user deposits - $user_deposit_payments_fmt,";
            $user_set_loan_limit_desc .= " user shares - $user_shares_payments_fmt,";
            $user_set_loan_limit_desc .= " user registration - $user_reg_payments_fmt";

        } elseif ($loan_limit_calculation_id == $contribution_initial_loan_limit) {

            $user_set_loan_limit = $initial_loan_limit;
            $user_set_loan_limit_desc = "initial loan limit - $initial_loan_limit_fmt";

        } else {

            $user_set_loan_limit = $user_deposit_payments;
            $user_set_loan_limit_desc = "user deposits - $user_deposit_payments_fmt";

        }

        //dd($user_set_loan_limit, $user_set_loan_limit_desc);

        $attributes['contributions_at_application'] = $user_set_loan_limit;
        $attributes['contributions_at_application_comments'] = $user_set_loan_limit_desc;
        $attributes['exposure_limit_at_application'] = $user_loan_exposure_limit;

        //////////////////////////////////////////////////

        //save new application record
        try {

            //create new loan application
            $loan_application = new LoanApplication();

            $new_loan_application = $loan_application->create($attributes);

            //store audits
            storeLoanApplicationAudit($new_loan_application->id);

        } catch(\Exception $e) {

            //DB::rollback();
            //dd($e);
            $message = $e->getMessage();
            log_this($message);
            $show_message['message'] = $message;
            return show_json_error($show_message);

        }

        //dd($new_loan_application);

        if ($new_loan_application) {

            //start save loan application report section data
            try {
                            
                //report section items
                $report_section_loan_applications = config('constants.report_section.loan_applications');
                        
                $current_date_obj_new = getCurrentDateObj();
                $data_parent_id = $new_loan_application->id;
                $ref_txt = "new loan application";
                $tran_ref_txt = $ref_txt;
                $tran_desc = $ref_txt;
                $amount_to_store = $loan_amt;
                $payment_id = NULL;
                $mpesa_code = "";
                $result = createNewReportSectionData($report_section_loan_applications, $company_id, 
                                                    $amount_to_store, $current_date_obj_new, $data_parent_id, $payment_id, 
                                                    $company_user_id, $mpesa_code, $tran_ref_txt, $tran_desc, $company_product_id);

            } catch (\Exception $e) {

                DB::rollback();
                //ssdd($e);
                $message_text = $e->getMessage();
                log_this($message_text);
                $show_message = "Error processing loan. Please try again later.";
                //$show_message .= $message_text;
                throw new StoreResourceFailedException($show_message);

            }
            //end save loan application report section data

        }


        DB::beginTransaction();


        if ($new_loan_application) {
            
            //start loan approval/ decline
            
            try {

                //attempt to check the loan validity 
                $loan_application_check = new LoanApplicationCheck();
                $result = $loan_application_check->approveItem($new_loan_application->id);
                //dd($result);
                $result_json = json_decode($result);
                $response = $result_json->message;

            } catch(\Exception $e) {

                //dd($e);
                DB::rollback();
                $message = $e->getMessage();
                log_this($message);

                $loan_application_failed = true;

                if ($loans_exceeding_limit == "queue") {

                    //allow application in queue
                    $queue_declined_application = true;

                    $new_loan_application->update([
                        'comments' => $message
                    ]);

                } else {

                    //auto decline the loan application
                    $new_loan_application->update([
                            'status_id' => $status_autodeclined,
                            'declined_by' => "-1",
                            'declined_by_name' => "System",
                            'comments' => $message
                        ]);
                    $show_message['message'] = $message;
                    $show_error = true;
                    $response = $show_message;

                }

                //store audits
                storeLoanApplicationAudit($new_loan_application->id);

            }

        } else {

            $message = "Loan application could not be created. Please try again later";
            log_this($message);
            $show_message['message'] = $message;
            return show_json_error($show_message);
        }
        //end loan approval/ decline

        //if loan has been queued, send msg back
        if ($loan_application_failed && $queue_declined_application) {

            $response['message'] = "Your loan application has been received and will be processed shortly.";

        }

        //return final result
        if ($show_error){
            $response = show_json_error($response);
        } else {
            $response = show_json_success($response);
        }


        DB::commit();


        return $response;


    }

}