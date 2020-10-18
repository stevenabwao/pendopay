<?php

namespace App\Services\User;

use App\Entities\DepositAccount;
use App\User;
use Illuminate\Support\Facades\DB;

class UserRegisterStore
{

    public function createItem($attributes) {

        // dd($attributes);

        DB::beginTransaction();

            //get data
            $phone = "";
            $email = "";
            $password = "";
            $dob = "";

            if (array_key_exists('phone', $attributes)) {
                $phone = $attributes['phone'];
                $attributes['phone'] = getDatabasePhoneNumber($phone);
            }
            if (array_key_exists('email', $attributes)) {
                $email = $attributes['email'];
            }
            if (array_key_exists('password', $attributes)) {
                $password = $attributes['password'];
                $attributes['password2'] = encryptData($password);
                $attributes['password'] = bcrypt($password);
            }
            if (array_key_exists('dob', $attributes)) {
                $dob = $attributes['dob'];
            }
            if (array_key_exists('county_id', $attributes)) {
                $county_id = $attributes['county_id'];
                $county_data = getCounties($county_id)->first();
                $county_name = $county_data->name;
                $attributes['county_name'] = $county_data->name;
            }

            // get minimum allowed age
            /* $site_settings = getSiteSettings();
            $min_age = $site_settings['minimum_user_age'];

            // get submitted user age
            $interval="year";
            $user_age = getDateDiff($dob, "", $interval);

            if ($user_age < $min_age) {
                $message['message'] = "You must be above 18 to use this site";
                return show_error_response($message);
            } */

            //start check if user exists
            $user_data = getUserData($phone, $email);

            //if user data already exists, throw an error
            if ($user_data) {
                $message['message'] = "User data already exists. Please try again, or login.";
                return show_error_response($message);
            }
            // end check if user exists

            // add user env
            $agent = new \Jenssegers\Agent\Agent;

            $attributes['user_agent'] = serialize($agent);
            $attributes['browser'] = $agent->browser();
            $attributes['browser_version'] = $agent->version($agent->browser());
            $attributes['os'] = $agent->platform();
            $attributes['device'] = $agent->device();
            $attributes['src_ip'] = getIp();
            // end add user env

            // add created_by and updated_by details
            if (getLoggedUser()) {
                $logged_user_data = getLoggedUser();
                $attributes['created_by'] = $logged_user_data->id;
                $attributes['created_by_name'] = $logged_user_data->full_name;
                $attributes['updated_by'] = $logged_user_data->id;
                $attributes['updated_by_name'] = $logged_user_data->full_name;
            }

            // re arrange dob
            /* $attributes['dob'] = reArrangeSubmittedDate($dob) . ' 00:00:00';
            $attributes['phone_country'] = 'KE'; */

            // set inactive status
            $attributes['status_id'] = getStatusInactive();
            $attributes['active'] = getStatusInactive();

            // unset terms
            unset($attributes['dob']);
            unset($attributes['terms']);
            unset($attributes['password_confirmation']);
            // dd($attributes);

            // start create new user
            try {

                $user = new User();
                $new_user = $user->create($attributes);

                $message['message'] = $new_user;
                $response = show_success_response($message);

            } catch(\Exception $e) {

                DB::rollback();
                // dd($e);
                $message['message'] = "Error creating user account. Please try again later";
                return show_error_response($message);

            }
            // end create new user

            // start create new user deposit account
            try {

                $deposit_account = new DepositAccount();

                $deposit_account_attributes['account_name'] = $attributes['first_name'] . " " . $attributes['last_name'];
                $deposit_account_attributes['account_no'] = generate_account_number(getDefaultCompanyId(),
                                                                                    getDefaultBranchCd(),
                                                                                    $new_user->id,
                                                                                    getDefaultAccountTypeCd());
                $deposit_account_attributes['currency_id'] = '1';
                $deposit_account_attributes['phone'] = $new_user->phone;
                $deposit_account_attributes['user_id'] = $new_user->id;
                $deposit_account_attributes['created_by'] = $new_user->id;
                $deposit_account_attributes['created_by_name'] = $new_user->full_name;
                $deposit_account_attributes['updated_by'] = $new_user->id;
                $deposit_account_attributes['updated_by_name'] = $new_user->full_name;
                $deposit_account_attributes['opened_at'] = getCurrentDate(1);
                $deposit_account_attributes['available_at'] = getCurrentDate(1);
                $deposit_account_attributes['status_id'] = getStatusActive();

                $new_deposit_account = $deposit_account->create($deposit_account_attributes);
                log_this(json_encode($new_deposit_account));

                // send account activation email/ sms
                sendAccountActivationDetails($phone, $email);

            } catch(\Exception $e) {

                DB::rollback();
                dd($e);
                $message['message'] = "Error creating user deposit account. Please try again later";
                return show_error_response($message);

            }
            // end create new user deposit account

        DB::commit();

        return $response;

    }

}
