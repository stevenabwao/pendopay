<?php

namespace App\Services\ManageData;

use App\Entities\LoanAccount;
use App\Entities\Offer;
use App\Entities\ReminderMessageSetting;
use App\Entities\ReminderMessage;
use App\Services\ReminderMessage\ReminderMessageStore;
use App\Services\EmailSend\EmailSendStore;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;

use Mail;
use App\Mail\OverdueLoanReminder;

class ManageDataIndex
{

	public function getData($request)
	{

        // PROCESS DATA
        // 1. PROCESS ALMOST EXPIRING NON-PAID ORDERS
        checkAlmostExpiringNonPaidOrders();

        // 2. PROCESS EXPIRED OFFERS
        processExpiredOffers();

        // 3. PROCESS EXPIRED ORDERS
        processExpiredOrders();

        /* DB::beginTransaction();

            DB::enableQueryLog();

            //statuses
            $status_open = config('constants.status.open');
            $status_active = config('constants.status.active');

            //products
            $mobile_loan_product_id = config('constants.account_settings.mobile_loan_product_id');
            $loan_account_product_id = config('constants.account_settings.loan_account_product_id');
            $deposit_account_product_id = config('constants.account_settings.deposit_account_product_id');
            $registration_account_product_id = config('constants.account_settings.registration_account_product_id');

            //reminder type sections
            $overdue_loans_reminder_type_section_id = config('constants.reminder_type_sections.overdue_loans');
            $almost_expiring_loans_reminder_type_section_id = config('constants.reminder_type_sections.almost_expiring_loans');

            //reminder message types
            $overdue_loans_reminder_message_type = config('constants.reminder_message_types.overdue_loans');
            $almost_expiring_loans_reminder_message_type = config('constants.reminder_message_types.almost_expiring_loans');

            //duration
            $duration_day = config('constants.duration.day');
            $duration_week = config('constants.duration.week');
            $duration_month = config('constants.duration.month');
            $duration_year = config('constants.duration.year');

            //repayment_reminder_variables
            $repayment_reminder_active = false;

            //***********************************************************
            //3. PROCESS EXPIRED LOAN REPAYMENTS - REMINDERS - START
            //***********************************************************

            //get expired loan accounts
            $loan_accounts_data = new LoanAccount();
            $current_date = getCurrentDateObj();
            $current_date_str = getCurrentDate();
            $current_date_day = $current_date->startOfDay();

            //get a list of all reminder message settings
            $reminder_message_settings = ReminderMessageSetting::where("status_id", $status_active)
                                                                ->orderBy("id", "desc")
                                                                ->get();
            //dd($reminder_message_settings);

            foreach ($reminder_message_settings as $reminder_message_setting) {

                //get reminder settings values
                $company_id = $reminder_message_setting->company_id;
                $product_id = $reminder_message_setting->product_id;
                $reminder_message_type_id = $reminder_message_setting->reminder_message_type_id;
                $reminder_message_type_section_id = $reminder_message_setting->reminder_message_type_section_id;
                $max_reminder_messages = $reminder_message_setting->max_reminder_messages;
                $reminder_message_cycle_id = $reminder_message_setting->reminder_message_cycle_id;
                $send_sms = $reminder_message_setting->send_sms;
                $send_email = $reminder_message_setting->send_email;
                $reminder_message_send_to_expiry_value = $reminder_message_setting->reminder_message_send_to_expiry_value;
                $reminder_message_send_to_expiry_cycle_id = $reminder_message_setting->reminder_message_send_to_expiry_cycle_id;
                $reminder_message_send_on_each_schedule = $reminder_message_setting->reminder_message_send_on_each_schedule;

                //dd("company_id - $company_id - reminder_message_type_section_id - $reminder_message_type_section_id");

                //start get main paybill no
                $mpesa_paybill_data = getMainSingleCompanyPaybill($company_id);
                $mpesa_paybill_data = json_decode($mpesa_paybill_data);
                $mpesa_paybill_data = $mpesa_paybill_data->data;
                $mpesa_paybill = $mpesa_paybill_data->paybill_number;
                //$mpesa_paybill = "811916";
                //end get main paybill no

                //dd($reminder_message_setting);

                //initiate loop counter
                $target_loan_accounts = "";
                $loop_count = 0;
                $reminder_message_type = "";

                //almost expiring loans reminder
                if ($reminder_message_type_section_id == $almost_expiring_loans_reminder_type_section_id) {

                    //$almost_expiring_loan = true;

                    $reminder_message_type = $almost_expiring_loans_reminder_message_type;

                    //get new expected expiry date
                    $current_temp_day = $current_date->startOfDay();
                    $expected_expiry_date = $current_temp_day->addDays($reminder_message_send_to_expiry_value);

                    $target_loan_accounts = $loan_accounts_data->select('loan_accounts.*')
                                            ->join('accounts', 'loan_accounts.user_id', '=', 'accounts.user_id')
                                            ->join('deposit_account_summary', 'loan_accounts.user_id', '=', 'deposit_account_summary.user_id')
                                            ->whereDate('maturity_at', "=", $expected_expiry_date)
                                            ->where('loan_accounts.status_id', $status_open)
                                            ->where('loan_accounts.company_id', $company_id)
                                            ->orderBy('maturity_at')
                                            ->get();

                    //dd($expected_expiry_date, $target_loan_accounts);

                }

                //overdue loans reminder
                if ($reminder_message_type_section_id == $overdue_loans_reminder_type_section_id) {

                    //$reminder_message_type = "overdue_loan";

                    $reminder_message_type = $overdue_loans_reminder_message_type;

                    $target_loan_accounts = $loan_accounts_data->select('loan_accounts.*')
                                            ->join('accounts', 'loan_accounts.user_id', '=', 'accounts.user_id')
                                            ->join('deposit_account_summary', 'loan_accounts.user_id', '=', 'deposit_account_summary.user_id')
                                            ->whereDate('maturity_at', "<", $current_date_day)
                                            ->where('loan_accounts.status_id', $status_open)
                                            ->where('loan_accounts.company_id', $company_id)
                                            ->orderBy('maturity_at')
                                            ->get();

                    //dd($current_date_day, $target_loan_accounts);

                }

                //dump(DB::getQueryLog());


                //proceed only if target_loan_accounts is present
                if ($target_loan_accounts) {

                    foreach ($target_loan_accounts as $target_loan_account) {

                        //start check if maturity_at is tommorow
                        $is_date_tomorrow = "false";
                        $maturity_at = $target_loan_account->maturity_at;

                        if ($maturity_at->isTomorrow()) {
                            $is_date_tomorrow = "true";
                        }
                        //end check if maturity_at is tommorow
                        //dd($maturity_at, $is_date_tomorrow);

                        //process three entries at a time
                        if ($loop_count >= 3) {
                            continue;
                        }
                        //dd($target_loan_account);

                        //check if the loan has a reminder message that is still active
                        $loan_account_id = $target_loan_account->id;

                        //check if reminder is due for this account
                        $reminder_active = isReminderMessageActive($reminder_message_cycle_id, $max_reminder_messages,
                                                                    $mobile_loan_product_id, $reminder_message_type_section_id,
                                                                    $loan_account_id, $reminder_message_send_to_expiry_value);

                        //dd($reminder_active);
                        //dump($target_loan_account->account_name, $target_loan_account->maturity_at, $reminder_active);
                        //dump($reminder_active, $reminder_message_cycle_id, $max_reminder_messages, $mobile_loan_product_id, $reminder_message_type_section_id, $loan_account_id);
                        //only proceed if reminder is active
                        if ($reminder_active) {



                            //dd("before");
                            //dump($target_loan_account->account_name, $target_loan_account->maturity_at, $reminder_active);

                            $loan_bal = $target_loan_account->loan_bal_calc;
                            $loan_bal_fmt = formatCurrency($loan_bal);
                            $maturity_at = $target_loan_account->maturity_at;
                            //formatted
                            $maturity_at_fmt = formatDisplayDate($maturity_at);

                            //dd("mid");

                            //get user details
                            $company_user = $target_loan_account->companyuser;
                            $company_user_id = $company_user->id;

                            //dd("after");

                            //start create new entry
                            try {

                                $reminder_message_store = new ReminderMessageStore();

                                $reminder_message_store_attributes['company_user_id'] = $company_user_id;
                                $reminder_message_store_attributes['company_id'] = $company_id;
                                $reminder_message_store_attributes['reminder_cycle'] = $reminder_message_cycle_id;
                                $reminder_message_store_attributes['reminder_period'] = $max_reminder_messages;
                                $reminder_message_store_attributes['reminder_type'] = $mobile_loan_product_id;
                                $reminder_message_store_attributes['reminder_type_section'] = $reminder_message_type_section_id;
                                $reminder_message_store_attributes['send_sms'] = $send_sms;
                                $reminder_message_store_attributes['send_email'] = $send_email;
                                $reminder_message_store_attributes['loan_bal'] = $loan_bal_fmt;
                                $reminder_message_store_attributes['maturity_at'] = $maturity_at_fmt;
                                $reminder_message_store_attributes['parent_id'] = $loan_account_id;
                                $reminder_message_store_attributes['mpesa_paybill'] = $mpesa_paybill;
                                $reminder_message_store_attributes['is_date_tomorrow'] = $is_date_tomorrow;

                                //dd($reminder_message_store_attributes);

                                $new_reminder_message_store = $reminder_message_store->createItem($reminder_message_store_attributes);

                                //dd($reminder_message_store_attributes, $new_reminder_message_store);
                                //increase loop on each successful send
                                $loop_count++;

                            } catch(\Exception $e) {

                                DB::rollback();
                                $message = $e->getMessage();
                                //dd($e);
                                //dd("new_reminder_message_store - " . $message);
                                log_this($message);
                                $show_message_text = "Error creating reminder message.";
                                throw new StoreResourceFailedException($show_message_text);

                            }
                            //end create new rem entry
                            //dd('heresss', $new_reminder_message_store);

                        }

                    }
                    //dd("end it");

                }


            }


            //***********************************************************
            //3. PROCESS EXPIRED LOAN REPAYMENTS - REMINDERS - END
            //***********************************************************



            //***********************************************************
            //4. SEND QUEUED EMAILS - START
            //***********************************************************
            //start create new entry
            try {

                //start create email send entry
                $email_send_store = new EmailSendStore();

                $new_email_send_store = $email_send_store->createItem();
                //dd($new_email_send_store);

            } catch(\Exception $e) {

                DB::rollback();
                $message = $e->getMessage();
                //dd("email_send_store - " . $message, $e);
                log_this($message);
                $show_message_text = "Error creating email send store";
                throw new StoreResourceFailedException($show_message_text);

            }

            //***********************************************************
            //4. SEND QUEUED EMAILS - END
            //***********************************************************
            //dd("end");

        DB::commit(); */


	}

}
