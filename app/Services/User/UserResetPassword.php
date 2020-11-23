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

        $response = [];

        //get the submitted data
        $token = "";

        if (array_key_exists('token', $attributes)) {
            $token = $attributes['token'];
        }

        // start get password reset record
        try {

            $password_reset = PasswordReset::where('token', $token)
                                           ->where('status_id', getStatusActive())
                                           ->first();

            if ($password_reset) {

                // get email address
                $email = $password_reset->email;

                // disable all previous reset entries for this email
                disablePreviousResets($email);

            } else {

                $message = "Invalid password reset link";
                throw new \Exception($message);

            }

        } catch(\Exception $e) {

            DB::rollback();
            $message = "An error occured. Try again. " . $e->getMessage();
            throw new \Exception($message);

        }
        // end get password reset record


        //start get user record
        try {

            // DB::enableQueryLog();

            $user = User::where('email', $email)->first();
            // dd($user, $attributes);

            if ($user) {

                $attributes['user_id'] = $user->id;
                $attributes['user_id'] = $user->id;

                // dd("user == ", $user);
                // update user password
                unset($attributes['token']);
                unset($attributes['new_password_confirmation']);
                $result = $user->updateUserPassword($attributes);
                // dd("result == ", $result, $attributes);

                // send password reset email to user
                // sendPasswordResetEmail($new_reset_data);

                $message['message'] = "Password has been successfully reset. Please login.";
                $response = show_success_response($message);

            } else {

                $message = "Invalid Password reset link";
                throw new \Exception($message);

            }

        } catch(\Exception $e) {

            DB::rollback();
            $message = "An error occured. Try again. " . $e->getMessage();
            throw new \Exception($message);

        }
        //end get user

        DB::commit();

        return $response;

    }

}
