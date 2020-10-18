<?php

namespace App\Services\User;

use App\Entities\ConfirmCode;
use App\User;
use Illuminate\Support\Facades\DB;

class ResendConfirmCode
{

    public function createItem($attributes) {

        // global variables
        $status_active = config('constants.status.active');
        $status_disabled = config('constants.status.disabled');

        //get data
        $phone = "";

        if (array_key_exists('phone', $attributes)) {
            $phone = getDatabasePhoneNumber($attributes['phone']);
            $attributes['phone'] = $phone;
        }

        // resend activation code
        DB::beginTransaction();

            // start get user
            try {

                $user = getUserData($phone);

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

            // send activation code
            try {

                // resend account activation email/ sms
                $resent_flag = true;
                sendAccountActivationDetails($phone, "", $resent_flag);

            } catch(\Exception $e) {

                DB::rollback();
                $message = "Could not send activation code";
                log_this('Error activating user phone === ' . $message . "\n" . json_encode($attributes));
                return show_error_response($message);

            }

        DB::commit();

        $message = "Activation code successfully resent";
        log_this('Success resending activation code === ' . $message . "\n" . json_encode($attributes));

        return show_success_response($message);

    }

}
