<?php

namespace App\Services\User;

use App\Entities\ConfirmCode;
use App\User;
use Illuminate\Support\Facades\DB;

class UserConfirm
{

    public function createItem($attributes) {

        // dd("attributes == ", $attributes);
        //global variables
        $status_active = config('constants.status.active');
        $status_disabled = config('constants.status.disabled');

        //get data
        $phone = "";
        $code = "";
        $email = "";

        if (array_key_exists('phone', $attributes)) {
            $phone = getDatabasePhoneNumber($attributes['phone']);
            $attributes['phone'] = $phone;
        }
        if (array_key_exists('code', $attributes)) {
            $code = $attributes['code'];
        }
        if (array_key_exists('email', $attributes)) {
            $email = $attributes['email'];
        }

        // activate account
        DB::beginTransaction();

            // start get user
            try {

                $user = getUserData($phone, $email);

            } catch(\Exception $e) {

                DB::rollback();
                $message = "User not found";
                log_this('Error activating user phone === ' . $message . "\n" . json_encode($attributes));
                return show_error_response($message);

            }
            // end get user

            // show error if user not found
            if (!$user) {
                $message = "User not found";
                log_this('Error activating user phone === ' . $message . "\n" . json_encode($attributes));
                return show_error_response($message);
            }

            // if user is already active, show error
            if ($user->status_id == $status_active) {
                $message = 'User account is already active.';
                log_this('Error activating user phone === ' . $message . "\n" . json_encode($attributes));
                return show_error_response($message);
            }

            // start check if supplied code is active
            $code_data = getConfirmCodeData($code, $phone);

            if (!$code_data) {
                $message = 'Invalid confirmation code.';
                log_this('Error activating user phone === ' . $message . "\n" . json_encode($attributes));
                return show_error_response($message);
            }
            // end check if supplied code is active

            // activate user record
            try {

                activateNewUser($phone);

            } catch(\Exception $e) {

                DB::rollback();
                $message = "Could not update user details";
                log_this('Error activating user phone === ' . $message . "\n" . json_encode($attributes));
                return show_error_response($message);

            }

            // disable this confirm codes for this user
            try {

                $code_data->update(['status_id' => $status_disabled]);

            } catch(\Exception $e) {

                DB::rollback();
                $message = "Could not update confirm code";
                log_this('Error activating user phone === ' . $message . "\n" . json_encode($attributes));
                return show_error_response($message);

            }

            // activate company user account
            // activate_user_company($user_id, $company_id);

        DB::commit();

        // fire event
        // event(new UserConfirmed($company_user));

        $message = "User phone successfully activated";
        log_this('Success activating user phone === ' . $message . "\n" . json_encode($attributes));

        return show_success_response($message);

    }

}
