<?php

namespace App\Services\ReminderMessage;

use App\Entities\LoanAccount; 
use App\Entities\ReminderMessage; 
use App\Entities\Company;
use App\Entities\CompanyUser;
use App\Entities\ReminderMessageSetting;
use App\Entities\ReminderMessageDetail;
use App\Services\EmailQueue\EmailQueueStore;
use App\User;
//use App\Events\LoanAccountUpdated;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use Mail;
use App\Mail\ReminderMessageEmail;

class ReminderMessageStore
{

	use Helpers;

    public function createItem($attributes) {

        //dd($attributes);

        DB::beginTransaction();

            $company_user_id = "";
            $reminder_cycle = "";
            $company_id = "";
            $reminder_period = "";
            $reminder_type = "";
            $reminder_type_section = "";
            $send_sms = "";
            $send_email = "";
            $loan_bal = "";
            $maturity_at = "";
            $parent_id = "";
            $mpesa_paybill = "";
            $is_date_tomorrow = false;

            if (array_key_exists('company_user_id', $attributes)) {
                $company_user_id = $attributes['company_user_id'];
            }
            if (array_key_exists('reminder_cycle', $attributes)) {
                $reminder_cycle = $attributes['reminder_cycle'];
            }
            if (array_key_exists('company_id', $attributes)) {
                $company_id = $attributes['company_id'];
            }
            if (array_key_exists('reminder_period', $attributes)) {
                $reminder_period = $attributes['reminder_period'];
            }
            if (array_key_exists('reminder_type', $attributes)) {
                $reminder_type = $attributes['reminder_type'];
            }
            if (array_key_exists('reminder_type_section', $attributes)) {
                $reminder_type_section = $attributes['reminder_type_section'];
            }
            if (array_key_exists('send_sms', $attributes)) {
                $send_sms = $attributes['send_sms'];
            }
            if (array_key_exists('send_email', $attributes)) {
                $send_email = $attributes['send_email'];
            }
            if (array_key_exists('loan_bal', $attributes)) {
                $loan_bal = $attributes['loan_bal'];
            }
            if (array_key_exists('maturity_at', $attributes)) {
                $maturity_at = $attributes['maturity_at'];
            }
            if (array_key_exists('parent_id', $attributes)) {
                $parent_id = $attributes['parent_id'];
            }
            if (array_key_exists('mpesa_paybill', $attributes)) {
                $mpesa_paybill = $attributes['mpesa_paybill'];
            }
            if (array_key_exists('is_date_tomorrow', $attributes)) {
                $is_date_tomorrow = $attributes['is_date_tomorrow'];
            }

            //dd($attributes);


            //proceed if company_user_id exists
            if ($company_user_id) {
                                            
                $is_active = "false";

                $current_date = getCurrentDateObj();

                $status_open = config('constants.status.open');
                $status_active = config('constants.status.active');

                //reminder message categories
                $reminder_category_sms = config('constants.reminder_category.sms');
                $reminder_category_email = config('constants.reminder_category.email');

                //duration
                $duration_day = config('constants.duration.day');
                $duration_week = config('constants.duration.week');
                $duration_month = config('constants.duration.month');
                $duration_year = config('constants.duration.year');

                //reminder type sections
                $overdue_loans_reminder_section_id = config('constants.reminder_type_sections.overdue_loans');
                $almost_expiring_loans_reminder_section_id = config('constants.reminder_type_sections.almost_expiring_loans');
                
                //reminder message types
                $overdue_loans_reminder_message_type = config('constants.reminder_message_types.overdue_loans');
                $almost_expiring_loans_reminder_message_type = config('constants.reminder_message_types.almost_expiring_loans');

                //products
                $mobile_loan_product_id = config('constants.account_settings.mobile_loan_product_id');
                $loan_account_product_id = config('constants.account_settings.loan_account_product_id');
                $deposit_account_product_id = config('constants.account_settings.deposit_account_product_id');
                $registration_account_product_id = config('constants.account_settings.registration_account_product_id');

                //vars
                $reminder_message = "";
                $email = "";
                $phone = "";
                $company_id = "";
                $company_name = "";
                $company_short_name = "";
                $full_names = "";
                $messages_count = 0;
                $reminder_message_id = "";
                $user_phone = "";
                $localised_phone = "";
                $new_messages_count = 0;

                try {

                    $company_user = CompanyUser::find($company_user_id);

                } catch(\Exception $e) {

                    DB::rollback();
                    //dd($e);
                    $message = $e->getMessage();
                    //dd("Company user not found - " . $message);
                    $show_message = "Company user not found:  $company_user_id -- ";
                    log_this($show_message . "<br>  company_user_id -" . $company_user_id);
                    throw new StoreResourceFailedException($show_message);
        
                }
                
                try {

                    //check whether max repay period has been exhausted
                    //get repayment_reminder_entry
                    $latest_reminder = new ReminderMessage();

                    if (($reminder_type == $mobile_loan_product_id) && ($parent_id)) {
                        $latest_reminder = $latest_reminder->where("loan_account_id", $parent_id);
                    }

                    $latest_reminder = $latest_reminder->first();

                } catch(\Exception $e) {

                    DB::rollback();
                    //dd($e);
                    $message = $e->getMessage();
                    //dd("Reminder message not found - " . $message);
                    $show_message = "Reminder message not found:  $company_user_id -- ";
                    log_this($show_message);
                    throw new StoreResourceFailedException($show_message);
        
                }

                

                if ($latest_reminder) {
                    //get last reminder date
                    $last_reminder_date = $latest_reminder->last_sent_at;
                    $messages_count = $latest_reminder->messages_count;  
                    $new_messages_count = $messages_count + 1;
                } else {
                    $new_messages_count = 1;
                }

                if ($company_user) {

                    $user = $company_user->user;

                    if ($user) {
                        $email = $user->email;
                        $phone = $user->phone;
                        $phone_country = $user->phone_country;
                        
                        if ($company_user) {
                            $company_id = $company_user->company_id;
                            $company_name = $company_user->company->name;
                            $company_short_name = $company_user->company->short_name;
                        }

                        $company_user_id = $company_user->id;
                        $first_name = titlecase($user->first_name);
                        $last_name = titlecase($user->last_name);
                        $full_names = $first_name . ' ' . $last_name;

                    }

                }

                ///start test ***********************
                //$email = "heavybitent@gmail.com";
                //$phone = "254720743211";
                ///end test ***********************

                if ($phone && $phone_country) {
                    $user_phone = getDatabasePhoneNumber($phone, $phone_country);
                    $localised_phone = getLocalisedPhoneNumber($phone, $phone_country);
                }
                //dd($localised_phone);

                //test ***********************************************************
                //$new_messages_count=1; 

                if (($reminder_type == $mobile_loan_product_id) && ($parent_id)) {

                    if ($company_user) {

                        $user = $company_user->user;

                        if ($user) {
                            
                            //create message
                            //sms
                            $reminder_message = "Dear " . titlecase($full_names) . ", ";
                            $reminder_message .= ordinal($new_messages_count) . " reminder:";
                            $reminder_message .= " Your loan balance of $loan_bal with $company_name";

                            if ($reminder_type_section == $overdue_loans_reminder_section_id) {
                                $reminder_message .= " was";
                            } else if ($reminder_type_section == $almost_expiring_loans_reminder_section_id) {
                                $reminder_message .= " is";
                            } else {
                                $reminder_message .= " is";
                            }

                            $reminder_message .= " due";

                            if ($is_date_tomorrow == "true") {
                                $reminder_message .= " tomorrow ($maturity_at).";
                            } else {
                                $reminder_message .= " on $maturity_at.";
                            }
                            
                            $reminder_message .= " Please make your repayments to Paybill: $mpesa_paybill A/C: $localised_phone";
                            $reminder_message .= " to qualify for more loans. Regards, $company_name";

                            //dd($reminder_message);

                            //email
                            $email_salutation = "Dear " . titlecase($full_names) . ", <br>";

                            $reminder_message_email = ordinal($new_messages_count) . " reminder:";
                            $reminder_message_email .= " Your loan balance of <strong>$loan_bal</strong> with $company_name ";

                            if ($reminder_type_section == $overdue_loans_reminder_section_id) {
                                $reminder_message_email .= " was";
                            } else if ($reminder_type_section == $almost_expiring_loans_reminder_section_id) {
                                $reminder_message_email .= " is";
                            } else {
                                $reminder_message_email .= " is";
                            }

                            $reminder_message_email .= " due";

                            if ($is_date_tomorrow == "true") {
                                $reminder_message_email .= " tomorrow <strong>($maturity_at)</strong>.";
                            } else {
                                $reminder_message_email .= " on <strong>$maturity_at</strong>.";
                            }

                            $reminder_message_email .= " <br><br>";
                            $reminder_message_email .= " Please make your repayments to Paybill: <strong>$mpesa_paybill</strong> A/C: <strong>$localised_phone</strong>";
                            $reminder_message_email .= " to qualify for more loans. <br><br>";

                            $email_footer = " Regards, <br>$company_name";

                        }

                    }

                }	
                
                //dd($latest_reminder);
                //dd($localised_phone, $user_phone, $mpesa_paybill, $email, $phone, $reminder_message, $user);

                if ($latest_reminder) {				
                                            
                    $reminder_message_id = $latest_reminder->id;

                    //start update existing reminder_message
                    $existing_reminder_attributes['last_sent_at'] = $current_date;
                    $existing_reminder_attributes['messages_count'] = $new_messages_count;
                    
                    $existing_reminder_message_result = $latest_reminder->updatedata($latest_reminder->id, $existing_reminder_attributes);
                    //end update existing reminder_message

                    $the_reminder_message = $latest_reminder;

                } else {

                    try {
                        
                        //DB::enableQueryLog();

                        //save new reminder_message
                        $new_reminder_message = new ReminderMessage();

                        $new_reminder_attributes['company_id'] = $company_id;
                        $new_reminder_attributes['reminder_message_type_id'] = $reminder_type;
                        $new_reminder_attributes['reminder_message_type_section_id'] = $reminder_type_section;
                        if ($user) {
                            $new_reminder_attributes['user_id'] = $user->id;
                        }
                        if ($company_user_id) {
                            $new_reminder_attributes['company_user_id'] = $company_user_id;
                        }
                        if ($reminder_type == $mobile_loan_product_id){
                            $new_reminder_attributes['loan_account_id'] = $parent_id;
                        }
                        $new_reminder_attributes['last_sent_at'] = $current_date;
                        $new_reminder_attributes['messages_count'] = $new_messages_count;
                        $new_reminder_attributes['user_phone'] = $user_phone;
                        $new_reminder_attributes['localised_phone'] = $localised_phone;
                        
                        $the_reminder_message = $new_reminder_message->create($new_reminder_attributes);

                        //dd($the_reminder_message);

                        $reminder_message_id = $the_reminder_message->id;

                        //dd(DB::getQueryLog());

                    } catch (\Exception $e) {
    
                        DB::rollback();
                        $message = $e->getMessage();
                        //dd($e);
                        //dd("Could not create new reminder message - " . $message);
                        $show_message = "Could not create new reminder message:  " . json_encode($new_reminder_attributes) . " -- ";
                        log_this($show_message . "<br>  new_reminder_attributes -" . $new_reminder_attributes);
                        throw new StoreResourceFailedException($show_message);
            
                    }

                }

                //dd($phone, $email);

                //doees user have a phone number
                if ($phone) {

                    //$phone = "254720743211";
                        
                    //sms type
                    $sms_type_id = config('constants.sms_types.reminder_sms');
                    
                    //send sms reminder
                    if ($send_sms == $status_active) {
                        $result = createSmsOutbox($reminder_message, $phone, $sms_type_id, $company_id, $company_user_id);
                    }

                    //start create new reminder message detail
                    try {

                        $new_reminder_message_detail = createNewReminderMessageDetail($company_id, $reminder_message_id,
                                                            $reminder_message, $phone, $email, $reminder_category_sms, $parent_id);

                    } catch (\Exception $e) {

                        DB::rollback();
                        $message = $e->getMessage();
                        //dd($e);
                        //dd("Could not find reminder message - " . $message);
                        $show_message = "Could not create new_reminder_message_detail";
                        log_this($show_message . "<br>  email_reminder_id -" . $reminder_message_id);
                        throw new StoreResourceFailedException($show_message);
            
                    } 
                    //end create new reminder message detail

                }

                

                if ($email) {
                    
                    //send email reminder
                    if (($reminder_type == $mobile_loan_product_id) && ($send_email == $status_active)){
                
                        
                        try {
                            
                            //dd($the_reminder_message);

                            $email_reminder = $the_reminder_message;

                            $email_reminder->reminder_message = $reminder_message;
                            $email_reminder->first_name = $first_name;
                            $email_reminder->full_names = $full_names;
                            $email_reminder->email = $email;
                            $email_reminder->phone = $phone;
                            $email_reminder->company_id = $company_id;
                            $email_reminder->company_name = $company_name;
                            $email_reminder->company_short_name = $company_short_name;
                            $email_reminder->mpesa_paybill = $mpesa_paybill;
                            $email_reminder->messages_count = $new_messages_count;
                            $email_reminder->reminder_type = $reminder_type;

                            $reminder_count_text = ordinal($new_messages_count); 
                            $reminder_type_text = "";

                            //get reminder type
                            if ($reminder_type == $mobile_loan_product_id){
                                $reminder_type_text = "Loan Repayment";
                                //$parent_id = $parent_id;
                                //set subject
                                $subject = 'Dear ' . titlecase($first_name) . ', ' . $reminder_count_text . ' ';
                                $subject .= $reminder_type_text . ' Reminder from ' . $company_short_name;
                                $email_text = $reminder_message_email;
                            }
                            $title = $subject;
                            $panel_text = "";
                            $email_footer = "Regards, <br>" . $company_name;

                        } catch (\Exception $e) {
    
                            DB::rollback();
                            $message = $e->getMessage();
                            //dd($e);
                            //dd("Could not find reminder message - " . $message);
                            $show_message = "Could not find reminder message:  $reminder_message_id -- ";
                            log_this($show_message . "<br>  email_reminder -" . $email_reminder);
                            throw new StoreResourceFailedException($show_message);
                
                        } 

                        //send email to queue
                        try {

                            $result = sendTheEmailToQueue($email, $subject, $title, $company_name, $email_text, $email_salutation, 
                                $company_id, $email_footer, $panel_text, "", $parent_id, $reminder_message_id);

                        } catch (\Exception $e) {

                            DB::rollback();
                            $message = $e->getMessage();
                            //dd($e);
                            //dd("Could not find reminder message - " . $message);
                            $show_message = "Could not send email to queue";
                            log_this($show_message . "<br>  email_reminder_id -" . $reminder_message_id);
                            throw new StoreResourceFailedException($show_message);
                
                        } 
                             
                            
                    }

                    //start create new reminder message detail
                    try {

                        $new_reminder_message_detail = createNewReminderMessageDetail($company_id, $reminder_message_id,
                                                            $email_text, $phone, $email, $reminder_category_email, $parent_id);

                    } catch (\Exception $e) {

                        DB::rollback();
                        $message = $e->getMessage();
                        //dd($e);
                        $show_message = "Could not create new_reminder_message_detail";
                        log_this($show_message . "<br>  email_reminder_id -" . $reminder_message_id);
                        throw new StoreResourceFailedException($show_message);
            
                    } 
                    
                    //end create new reminder message detail

                    //dd($new_reminder_message_detail);
                    
                }

            }

        

        DB::commit();


        return json_encode($new_reminder_message_detail);

    }

}