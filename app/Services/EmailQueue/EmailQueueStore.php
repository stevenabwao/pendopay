<?php

namespace App\Services\EmailQueue;

use App\Entities\EmailQueue;
use App\Entities\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; 

class EmailQueueStore
{

	public function createItem($attributes) {

        $subject = "";
        $title = "";
        $company_name = "";
        $email_text = ""; 
        $panel_text = ""; 
        $table_text = ""; 
        $email_salutation = ""; 
        $email_footer = ""; 
        $email_address = "";
        $parent_id = "";
        $reminder_message_id = "";
        $company_id = "";

        if (array_key_exists('subject', $attributes)) {
            $subject = $attributes['subject'];
        }
        if (array_key_exists('title', $attributes)) {
            $title = $attributes['title'];
        }
        if (array_key_exists('company_name', $attributes)) {
            $company_name = $attributes['company_name'];
        }
        if (array_key_exists('email_text', $attributes)) {
            $email_text = $attributes['email_text'];
        }
        if (array_key_exists('panel_text', $attributes)) {
            $panel_text = $attributes['panel_text'];
        }
        if (array_key_exists('table_text', $attributes)) {
            $table_text = $attributes['table_text'];
        }
        if (array_key_exists('email_salutation', $attributes)) {
            $email_salutation = $attributes['email_salutation'];
        }
        if (array_key_exists('email_footer', $attributes)) {
            $email_footer = $attributes['email_footer'];
        }
        if (array_key_exists('email_address', $attributes)) {
            $email_address = $attributes['email_address'];
        }
        if (array_key_exists('parent_id', $attributes)) {
            $parent_id = $attributes['parent_id'];
        }
        if (array_key_exists('reminder_message_id', $attributes)) {
            $reminder_message_id = $attributes['reminder_message_id'];
        }
        if (array_key_exists('company_id', $attributes)) {
            $company_id = $attributes['company_id'];
        }
        if (array_key_exists('has_attachments', $attributes)) {
            $has_attachments = $attributes['has_attachments'];
        }

        //set new attributes
        $attributes['company_name'] = $company_name;
        $attributes['email_text'] = $email_text;
        $attributes['email_address'] = $email_address;
        $attributes['company_id'] = $company_id;
        $attributes['subject'] = $subject;
        $attributes['title'] = $title;
        $attributes['panel_text'] = $panel_text;
        $attributes['table_text'] = $table_text;
        $attributes['email_salutation'] = $email_salutation;
        $attributes['email_footer'] = $email_footer;
        $attributes['parent_id'] = $parent_id;
        $attributes['reminder_message_id'] = $reminder_message_id;
        $attributes['has_attachments'] = $has_attachments;
        $attributes['status_id'] = config('constants.status.pending');

        //get email provider
        $attributes['email_provider_name'] = strtolower(getEmailDomainName($email_address));

        //dd($attributes);

        //save new queue record
        try {

            //create new loan application
            $email_queue = new EmailQueue();

            $new_email_queue = $email_queue->create($attributes);

            $response['message'] = "Email has been added to the emails queue";

        } catch(\Exception $e) { 

            DB::rollback();
            //dd($e);
            $message = $e->getMessage();
            log_this($message);
            $message_txt['message'] = $message;
            return show_json_error($message_txt);

        }

        //dd($new_loan_application);
        
        DB::commit();
        
        return show_json_success($response);


    }

}