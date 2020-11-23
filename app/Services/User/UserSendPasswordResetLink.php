<?php

namespace App\Services\User;

use App\Entities\CompanyUser;
use App\Entities\PasswordReset;
use App\User;
use Illuminate\Support\Facades\DB;

class UserSendPasswordResetLink
{


    public function createItem($attributes) {

        DB::beginTransaction();

        $response = [];

        //get the submitted data
        $email = "";

        if (array_key_exists('email', $attributes)) {
            $email = $attributes['email'];
        }

        // start get password reset record
        try {

            $user = User::where('email', $email)->first();
            // dd("user == ", $user);

            if ($user) {

                // disable all previous reset entries for this email
                disablePreviousResets($email);

                // get site settings
                $site_settings = getSiteSettings();
                $token_length = $site_settings['password_reset_token_length'];

                // reset token
                $token = generateCode($token_length, "", "lud");

                // store password reset entry
                $new_password_reset = new PasswordReset();

                $new_password_reset_attributes = [];
                $new_password_reset_attributes['email'] = $email;
                $new_password_reset_attributes['token'] = $token;
                $new_password_reset_attributes['ip'] = getIp();
                $new_password_reset_attributes['status_id'] = getStatusActive();
                // dd("new_password_reset_attributes == ", $new_password_reset_attributes);

                $result = $new_password_reset->create($new_password_reset_attributes);
                // dd("result == ", $result);

                // send password reset email
                $new_reset_data['email'] = $email;
                $new_reset_data['token'] = $token;

                sendPasswordResetEmail($new_reset_data);

                // send user response
                $message = "We have emailed your password reset link!";
                $response = show_success_response($message);

            } else {

                // send user response
                $message = "We have emailed your password reset link!";
                $response = show_success_response($message);

            }

        } catch(\Exception $e) {

            // dd($e);
            DB::rollback();
            $message = "An error occured. Try again. " . $e->getMessage();
            throw new \Exception($message);

        }
        // end get password reset record

        DB::commit();

        return $response;

    }

}
