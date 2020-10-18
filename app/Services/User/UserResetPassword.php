<?php

namespace App\Services\User;

use App\Entities\CompanyUser;
use App\Entities\PasswordReset;
use App\User;
use Illuminate\Support\Facades\DB;

class UserResetPassword
{


    public function createItem($attributes) {

        DB::beginTransaction();

        //get the submitted data
        $email = "";

        if (array_key_exists('email', $attributes)) {
            $email = $attributes['email'];
        }

        //start get user
        try {

            // DB::enableQueryLog();

            $user = User::where('email', $email)->first();

            if ($user) {

                // generate reset token
                $lower_upper_digits = "lud";
                $reset_token = generateCode(50, false, $lower_upper_digits);

                // disable all previous reset entries for this email
                disablePreviousResets($email);

                // create a new password reset entry
                $password_reset_data = new PasswordReset();

                $attributes['email'] = $email;
                $attributes['token'] = $reset_token;
                $attributes['status_id'] = getStatusActive();

                $new_reset_data = $password_reset_data->create($attributes);

                // send password reset email to user
                sendPasswordResetEmail($new_reset_data);

                $message = "Password reset link has been sent to your email address";
                $response = show_success_response($message);

            } else {
                $message = "Password reset link has been sent to your email address";
                // return show_error_response($message);
                $response = show_success_response($message);
            }

        } catch(\Exception $e) {

            DB::rollback();
            $message = "An error occured. Try again. " . $e;
            return show_error_response($message);

        }
        //end get user

        DB::commit();

        return $response;

    }

}
