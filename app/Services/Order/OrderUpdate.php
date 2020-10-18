<?php

namespace App\Services\Order;

use App\Entities\CompanyUser;
use App\Entities\LoanAccount;
use App\Entities\Order;
use App\Entities\LoanProductSetting;
use App\Services\Order\OrderApprove;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Dingo\Api\Exception\StoreResourceFailedException;

use Mail;
use App\Mail\NewLoanApprove;

class OrderUpdate
{

    public function updateItem($attributes) {

        $status_autodeclined = config('constants.status.autodeclined');
        $status_waiting = config('constants.status.waiting');

        $show_error = false;

        $trans_status = "";
        $request_id = "";

        if (array_key_exists('trans_status', $attributes)) {
            $trans_status = $attributes['trans_status'];
        }
        if (array_key_exists('request_id', $attributes)) {
            $request_id = $attributes['request_id'];
        }

        //try approve loan application

        //dd($attributes);

        DB::beginTransaction();

            //snb constants
            $snb_helpline = config('constants.snb_settings.helpline');
            $snb_website = config('constants.snb_settings.website');
            $snb_company_name = config('constants.snb_settings.company_name');
            $sms_type_id = config('constants.sms_types.company_sms');

            //start if status is completed, proceed
            if ($trans_status == 'completed') {

                try {

                    $the_loan_application = Order::find($request_id);

                    $company_product_id = $the_loan_application->company_product_id;
                    $company_id = $the_loan_application->company_id;
                    $loan_application_id = $the_loan_application->id;

                    $user = $the_loan_application->companyuser->user;
                    //dd($user, $the_loan_application);

                } catch(\Exception $e) {

                    DB::rollback();
                    //dd($e);
                    $show_message = "Error finding loan application record: " . $e->getMessage();
                    log_this($show_message);
                    throw new StoreResourceFailedException($show_message);

                }

                //if loan application is not waiting status, exit
                if ($the_loan_application->status_id != $status_waiting) {

                    //show error
                    $show_message = "Could not complete loan approval. Invalid loan application status.";
                    log_this($show_message);
                    throw new StoreResourceFailedException($show_message);

                }


                try {

                    //get the company loan product settings
                    $loan_product_setting = LoanProductSetting::where('company_product_id', $company_product_id)
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
                    //end get loan product settings
        
                } catch(\Exception $e) {
        
                    DB::rollback();
                    //dd($e);
                    $show_message = "Loan product setting not found. Company_id:  $company_id -- ";
                    $show_message .= " Company Product ID:  $company_product_id.";
                    log_this($show_message . "<br> Loan Application Id -" . $loan_application_id);
                    throw new StoreResourceFailedException($show_message);
        
                }
                //dd($the_loan_application);


                try {

                    //attempt to approve the loan
                    $loan_application_approve = new OrderApprove(); 
                    $result = $loan_application_approve->approveItem($request_id);

                    $result_json = json_decode($result);
                    $response = $result_json->message;

                    //dd($result_json); 

                    //if no error occured
                    if ($result_json->status_code == 200) {

                        $loan_repayment_schedules = $response->repayment_schedule;

                        $repay_msg = array();
                        $repayment_msg = ""; 

                        foreach ($loan_repayment_schedules as $loan_repayment_schedule)  {
                            $repay_date = $loan_repayment_schedule->date;
                            $repay_amount = $loan_repayment_schedule->amount;
                            $repay_msg[] = formatCurrency($repay_amount) . " by " . formatDisplayDate($repay_date);
                        }
                        $repayment_msg = implode(", ", $repay_msg);
                        //$last_payment_data = last($loan_repayment_schedules);
                        //$last_payment_date = $last_payment_data->date;

                        //start send success sms message
                        $phone_number = $user->phone;
                        $email = $user->email;
                        $loan_amount = $the_loan_application->loan_amt;
                        $company_id = $the_loan_application->company->id;
                        $company_user_id = $the_loan_application->company_user_id;
                        $company_name = $the_loan_application->company->name;
                        $snb_helpline = $the_loan_application->company->phone;
                        $first_name = titlecase($user->first_name);
                        $last_name = titlecase($user->last_name);
                        $full_name = $first_name . " " . $last_name;

                        $company_short_name = $the_loan_application->company->short_name;
                        if (!$company_short_name) {
                            $company_short_name = $company_name;
                        }

                        //get company user
                        $company_user = CompanyUser::find($company_user_id);

                        //send sms on successful loan
                        $loan_amount_fmt = formatCurrency($loan_amount);
                        $sms_message = "Dear $full_name, your loan application of $loan_amount_fmt has been successful. ";
                        $sms_message .= "Please repay your loan as follows: $repayment_msg. $company_name. Helpline: $snb_helpline";
                        //dd($sms_message);

                        $result = createSmsOutbox($sms_message, $phone_number, $sms_type_id, $company_id, $company_user_id);
                        //end send success sms message

                        //dd($last_payment_date);

                        
                        if ($email) {

                            //get loan account id
                            $loan_account_data = LoanAccount::where('loan_application_id', $request_id)->first();
                            $loan_account_id = $loan_account_data->id;

                            //send repayment schedule via email
                            $table_response = buildTableLoanRepaymentData($loan_account_id);

                            //set company user data
                            $company_user['message'] = $table_response;
                            $company_user['loan_amount'] = $loan_amount;

                            //send email to loan account user
                            if ($email) {

                                //Mail::to($email)
                                //    ->send(new NewLoanApprove($company_user)); 
                            
                                //start send email to queue
                                $subject = 'Dear ' . $first_name . ', Your Loan With ' . $company_short_name . " Has Been Approved";
                                $title = $subject;

                                $email_salutation = "Dear " . $first_name . " " . $last_name . ",<br><br>";

                                $email_text = "Your loan application of <strong>" . formatCurrency($loan_amount) . "</strong> at $company_name has been approved. <br><br>";
                                $email_text .= "Your loan repayment breakdown is as follows: <br>";

                                $panel_text = "";

                                $email_footer = "Regards,<br>";
                                $email_footer .= "$company_short_name Management";
                                
                                //email queue
                                $table_text = $table_response;

                                $parent_id = 0;
                                $reminder_message_id = 0;
                                
                                $result = sendTheEmailToQueue($email, $subject, $title, $company_name, $email_text, $email_salutation, 
                                $company_id, $email_footer, $panel_text, $table_text, $parent_id, $reminder_message_id);
                                //end send email to queue

                            }

                        }

                        //check whether mpesa balance limit has been set
                        //and whether limit has been reached
                        if ($company_id) {

                            log_this("check if mpesa balance limit reached");
                            checkIfMpesaBalanceLimitReached($company_id);

                        }

                    } else {

                        $show_error = true;

                    }

                } catch(\Exception $e) {

                    DB::rollback();
                    $show_message = $e->getMessage();
                    log_this($show_message);

                    //DB::rollback();
                    $loan_application_failed = true;

                    if ($loans_exceeding_limit == "queue") {

                        //allow application in queue
                        $queue_declined_application = true;

                        $the_loan_application->update([
                            'comments' => $show_message
                        ]);

                        //store audits
                        storeOrderAudit($request_id);

                    } else {

                        $show_message['message'] = $show_message;
                        $show_error = true;
                        $response = $show_message;

                    }

                }

            } else if ($trans_status == 'failed') {

                DB::rollback(); 
                //decline loan application
                $the_loan_application = Order::find($request_id);
                $show_message = "Error, could not process your loan at this time. Please try again later.";
                $full_message = $show_message . "<br>Insufficient funds<br> Loan Application Id -" . $request_id;
                log_this($full_message);
                
                //auto decline the loan application
                try {

                    $the_loan_application->update([
                        'status_id' => $status_autodeclined,
                        'declined_by' => "-1",
                        'declined_by_name' => "System",
                        'comments' => $full_message
                    ]);
                    $the_message['message'] = $show_message;
                    $show_error = true;
                    $response = $the_message;

                } catch(\Exception $e) {
            
                    DB::rollback();
                    //dd($e);
                    $show_message = "Error. Could not complete loan approval -- ";
                    log_this($show_message . "<br> Loan Application Id -" . $request_id);
                    throw new StoreResourceFailedException($show_message);
        
                }

                throw new StoreResourceFailedException($show_message);

            } else {

                //set loan application message
                $show_message = "Could not complete loan approval. Invalid trans_status.";
                log_this($show_message);
                throw new StoreResourceFailedException($show_message);

            }
            //end if auto approval method is set, proceed

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