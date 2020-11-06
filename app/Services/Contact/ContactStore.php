<?php

namespace App\Services\Contact;

use App\Entities\Contact;
use Illuminate\Support\Facades\DB;
use Mail;
use App\Mail\NewUserFeedback;

class ContactStore
{

    public function createItem($attributes) {

        DB::beginTransaction();

            $name = "";
            $message = "";
            $email = "";
            $phone = "";
            $subject = "";
            $captcha = "";

            if (array_key_exists('name', $attributes)) {
                $name = $attributes['name'];
            }
            if (array_key_exists('phone', $attributes)) {
                $phone = $attributes['phone'];
            }
            if (array_key_exists('message', $attributes)) {
                $message = $attributes['message'];
            }
            if (array_key_exists('subject', $attributes)) {
                $subject = $attributes['subject'];
            }
            if (array_key_exists('email', $attributes)) {
                $email = $attributes['email'];
            }
            if (array_key_exists('g-recaptcha-response', $attributes)) {
                $captcha = $attributes['g-recaptcha-response'];
            }

            //get user data
            try{
                $localised_phone = getDatabasePhoneNumber($phone);
            } catch (\Exception $e) {
                $message = "Error evaluating phone number - " . $e->getMessage();
                throw new \Exception($e->getMessage());
            }

            if(!$captcha){
                $message = "Please confirm the security box ";
                throw new \Exception($message);
            }

            $site_settings = getSiteSettings();
            $secretKey = $site_settings['recaptcha_secret_key'];

            $ip = $_SERVER['REMOTE_ADDR'];
            $response_text=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
            $responseKeys = json_decode($response_text,true);

            //if wrong captcha was entered, show error
            if(intval($responseKeys["success"]) !== 1) {
                $message = "Please confirm the security box properly";
                throw new \Exception($message);
            }

            //start create new user feedback
            try {

                $new_contact = new Contact();

                //add user env
                $agent = new \Jenssegers\Agent\Agent;

                //convert phone to standard local phone
                if (array_key_exists('phone', $attributes)) {
                    $phone = $localised_phone;
                }

                $new_contact_attributes['name'] = $name;
                $new_contact_attributes['email'] = $email;
                $new_contact_attributes['subject'] = $subject;
                $new_contact_attributes['message'] = $message;
                $new_contact_attributes['phone'] = $phone;
                $new_contact_attributes['user_agent'] = serialize($agent);
                $new_contact_attributes['browser'] = $agent->browser();
                $new_contact_attributes['browser_version'] = $agent->version($agent->browser());
                $new_contact_attributes['os'] = $agent->platform();
                $new_contact_attributes['device'] = $agent->device();
                $new_contact_attributes['src_ip'] = getIp();

                $result = $new_contact->create($new_contact_attributes);

                //get site settings
                $site_settings = getSiteSettings();
                $send_email_1 = $site_settings['send_email_1'];
                $company_name_title = $site_settings['company_name_title'];
                $contact_website = $site_settings['contact_website'];

                //add extra data to object
                $new_contact->company_website = $contact_website;
                $new_contact->company_name_title = $company_name_title;

                // dd($send_email_1, $email, $new_contact);

                //send admin email
                if ($send_email_1) {

                    $new_contact->send_to_admin = 1;
                    Mail::to($send_email_1)
                        ->send(new NewUserFeedback($new_contact));

                }

                //send user email
                if ($email) {

                    $new_contact->send_to_admin = 0;
                    $new_contact->send_to_user = 1;
                    Mail::to($email)
                        ->send(new NewUserFeedback($new_contact));

                }

                $response["message"] = $result;

            } catch(\Exception $e) {

                DB::rollback();
                $message = $e->getMessage();
                /* $response["message"] = $message;
                return show_json_error($response); */
                throw new \Exception($message);

            }
            //end create new feedback


        return show_json_success($response);

    }

}
