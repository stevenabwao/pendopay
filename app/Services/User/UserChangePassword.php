<?php

namespace App\Services\User;

use App\Entities\Account;
use App\Entities\ConfirmCode;
use App\Entities\DepositAccount;
use App\User;
use App\Services\User\CreateUserAccount;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserChangePassword
{

    use Helpers;

    public function changePassword($attributes) {

        //get the submitted data
        $email = "";
        $phone = "";
        $current_pin = "";
        $new_pin = "";

        if (array_key_exists('email', $attributes)) {
            $email = $attributes['email'];
            $the_account = $email;
        }
        if (array_key_exists('phone', $attributes)) {
            $phone = $attributes['phone'];
            $the_account = getDatabasePhoneNumber($phone);
        }

        $current_pin = $attributes['current_pin'];
        $new_pin = $attributes['new_pin'];

        //dd($attributes);

        if ($hasher->check($new_pin, $user->password)) {
        //if ($current_pin == $new_pin) {
            $message = "Your New PIN resembles the Current PIN. Try again.";
            return show_json_error($message);
        }

        //start get user
        try {

            //DB::enableQueryLog();
            $user = DB::table('users')
                        ->where('phone', $the_account)
                        ->orWhere('email', $the_account)
                        ->first();

            if ($user) {

                $hasher = app('hash');
                if ($hasher->check($current_pin, $user->password)) {
                    // success - user details exist
                    //change to new pin here
                    $new_password = bcrypt($new_pin);
                    //get user
                    $user_password_update = User::where('phone', $the_account)
                        ->orWhere('email', $the_account)
                        ->first();
                    //update user pin
                    $user_password_update->update([
                                    'password' => $new_password
                                ]);
                    //fire user updated event
                    //event(new UserUpdated($user_password_update));

                    $message = "PIN successfully updated";
                    return show_json_success($message);

                } else {
                    $message = "Wrong Current PIN entered. Try again.";
                    return show_json_error($message);
                }

            } else {
                $message = "Wrong PIN entered.";
                return show_json_error($message);
            }
            //print_r(DB::getQueryLog());

        } catch(\Exception $e) {

            DB::rollback();
            //throw new StoreResourceFailedException($e);
            $message = "User not found";
            return show_json_error($message);

        }
        //end get user

    }

}
