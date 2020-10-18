<?php

namespace App\Services\EmailSend;

use App\Entities\EmailQueue;
use App\Entities\EmailBatchDetail;
use App\Entities\EmailBatch;
use App\Entities\Company;
use App\Entities\ReminderMessageSetting;
use App\Entities\EmailProvider;
use App\Entities\EmailProviderSetting;
use Carbon\Carbon;
use Mail;
use App\Mail\ReminderMessageEmail;
use Illuminate\Support\Facades\DB;

class EmailSendStore
{

    public function createItem() {

        DB::beginTransaction();

        //check if send limit for today has been reached,
        //if so dont proceed
        //$remider_message_setting = EmailProviderSetting::where()->first();
        //dd("here");

        $status_sent = config('constants.status.sent');
        $status_pending = config('constants.status.pending');

        //get queued emails
        $queued_emails = EmailQueue::where('status_id', '!=', $status_sent)
            ->limit(5)
            ->orderBy('created_at', 'desc')
            ->get();

        //dd($queued_emails);

        if (count($queued_emails)) {

            //dd("here we go");

            $email_count = 0;

            //store emails in batch
            foreach ($queued_emails as $queued_email){

                //dd($queued_email);

                $queued_email_id = $queued_email->id;
                $email_provider_name = strtolower($queued_email->email_provider_name);
                $email_text = $queued_email->email_text;
                $email = $queued_email->email_address;
                $company_name = $queued_email->company_name;
                $panel_text = $queued_email->panel_text;
                $table_text = $queued_email->table_text;
                $email_salutation = $queued_email->email_salutation;
                $email_footer = $queued_email->email_footer;
                $subject = $queued_email->subject;
                $company_id = $queued_email->company_id;

                //set queued email object
                /*$queued_email->email_text = $email_text;
                $queued_email->panel_text = $panel_text;
                $queued_email->table_text = $table_text;
                $queued_email->email_footer = $email_footer;
                $queued_email->subject = $subject;
                $queued_email->company_id = $company_id;*/

                //check if send limit for today has been reached,
                //if so dont proceed
                //get provider setting - day_limit
                $email_provider_setting = EmailProviderSetting::where('email_provider_name', $email_provider_name)->first();
                //dd($email_provider_setting, $email_provider_name);
                if (!$email_provider_setting) {

                    //start create new email provider
                    $new_email_provider = new EmailProvider();

                    $new_email_provider_attributes['name'] = $email_provider_name;

                    $the_reminder_message = $new_email_provider->create($new_email_provider_attributes);
                    //end create new email provider

                    //start create new email provider setting
                    $new_email_provider_setting = new EmailProviderSetting();

                    $day_limit = 100;

                    $new_email_provider_setting_attributes['email_provider_name'] = $email_provider_name;
                    $new_email_provider_setting_attributes['day_limit'] = $day_limit;

                    $the_reminder_message = $new_email_provider_setting->create($new_email_provider_setting_attributes);
                    //end create new email provider setting

                } else {
                    $day_limit = $email_provider_setting->day_limit;
                }

                //dd($day_limit, $email_provider_setting);

                //start check if today's batch exists for email provider
                //if not exists, create one, else use the one that exists
                $current_date = getCurrentDate();
                $todays_batch = EmailBatch::whereDate('sent_at', $current_date)
                                ->where('email_provider_name', $email_provider_name)
                                ->first();

                //dd($current_date, $todays_batch);

                if ($todays_batch) {

                    //get number_emails count
                    $batch_id = $todays_batch->id;
                    $number_emails = $todays_batch->number_emails;

                    $the_email_batch = $todays_batch;

                } else {

                    try {

                        //create a new batch
                        $emailBatch = new EmailBatch();

                        $email_batch_attributes['sent_at'] = $current_date;
                        $email_batch_attributes['email_provider_name'] = $email_provider_name;
                        $email_batch_attributes['created_by'] = "1";
                        $email_batch_attributes['updated_by'] = "1";

                        $new_email_batch = $emailBatch->create($email_batch_attributes);

                        $number_emails = 0;

                        $the_email_batch = $new_email_batch;

                        $batch_id = $new_email_batch->id;

                    } catch(\Exception $e) {

                        DB::rollback();
                        $message = $e->getMessage();
                        //dd($message);
                        //dd("Error creating new batch - " . $message);
                        log_this($message);
                        $show_message_text = "Error creating new batch";
                        throw new \Exception($show_message_text);

                    }

                }

                //dd($number_emails <= $day_limit);


                if ($number_emails <= $day_limit) {

                    try {

                        //create email batch details
                        $emailBatchDetail = new EmailBatchDetail();

                        $email_batch_detail_attributes['email_queue_id'] = $queued_email_id;
                        $email_batch_detail_attributes['email_batch_id'] = $batch_id;
                        $email_batch_detail_attributes['created_by'] = "1";
                        $email_batch_detail_attributes['updated_by'] = "1";

                        $new_email_batch_detail = $emailBatchDetail->create($email_batch_detail_attributes);

                        $batch_detail_id = $new_email_batch_detail->id;

                    } catch(\Exception $e) {

                        DB::rollback();
                        $message = $e->getMessage();
                        //dd($message);
                        //dd("Error creating new batch detail - " . $message);
                        log_this($message);
                        $show_message_text = "Error creating new batch detail";
                        throw new \Exception($show_message_text);

                    }

                    //dd($new_email_batch_detail, $batch_detail_id);

                    //update number_emails count
                    try {

                        //$count_email_batch = EmailBatch::find($batch_id);
                        //dump($the_email_batch);

                        $email_batch_update = $the_email_batch
                            ->update([
                                'number_emails' => $number_emails + 1
                            ]);

                    } catch(\Exception $e) {

                        DB::rollback();
                        $message = $e->getMessage();
                        //dd("Error updating batch number emails - " . $message);
                        log_this($message);
                        $show_message_text = "Error updating batch number emails";
                        throw new \Exception($show_message_text);

                    }

                    //dd($email_batch_update);

                    //update email queue status_id to sent
                    try {

                        //$edit_status_email_queue = EmailQueue::find($queued_email_id);
                        //dd($edit_status_email_queue);

                        $edit_status_email_queue_update = $queued_email
                            ->update([
                                'status_id' => $status_sent
                            ]);

                    } catch(\Exception $e) {

                        DB::rollback();
                        $message = $e->getMessage();
                        //dd("Error updating email queue details - " . $message);
                        log_this($message);
                        $show_message_text = "Error updating email queue details";
                        throw new \Exception($show_message_text);

                    }

                    //dd($queued_email->toArray());


                    try {

                        //create and send email
                        Mail::to($email)
                            ->send(new ReminderMessageEmail($queued_email));

                    } catch(\Exception $e) {

                        DB::rollback();
                        $message = $e->getMessage();
                        //dd("Error sending email - " . $message);
                        log_this($message);
                        $show_message_text = "Error sending email - " . $message;
                        throw new \Exception($show_message_text);

                    }


                }

            }

        }

        DB::commit();

        //dd($email);

        //return show_json_success($edit_status_email_queue_update);


    }

}
