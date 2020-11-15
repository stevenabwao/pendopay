<?php

namespace App\Services\User;

use App\Entities\Company;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserStore
{

    public function createItem($attributes) {

        //dd($attributes);
        //current date and time
        $date = Carbon::now();
        $date = getLocalDate($date);
        $date = $date->toDateTimeString();


        DB::beginTransaction();

            $user = NULL;

            //get data
            $phone = "";
            $email = "";
            $id_no = "";
            //$id_no = $attributes['id_no'];
            $phone_country = "";

            if (array_key_exists('phone', $attributes)) {
                $phone = $attributes['phone'];
            }
            if (array_key_exists('id_no', $attributes)) {
                $id_no = $attributes['id_no'];
            }
            if (array_key_exists('email', $attributes)) {
                $email = $attributes['email'];
            }
            if (array_key_exists('phone_country', $attributes)) {
                $phone_country = $attributes['phone_country'];
            }

            //get phone number
            if ($phone_country) {
                $full_phone = getDatabasePhoneNumber($phone, $phone_country);
            } else {
                $full_phone = getDatabasePhoneNumber($phone);
            }

            //start check if company exists
            try {

                $company_data = Company::find($attributes['company_id']);

                //if no company record exists, throw an error
                if (!$company_data) {
                    //throw an error, company record does not exist
                    //throw new \Exception('Non existent company!!! Please check the company_id field');
                    $message = "Non existent company!!! Please check the company_id field";
                    return show_json_error($message);
                }

            } catch(\Exception $e) {

                DB::rollback();
                //throw new \Exception('Error fetching company record');
                $message = "Error fetching company record";
                return show_json_error($message);

            }
            //end check if company exists

            //check if user with phone number or email or id_no already exists
            $user_exists_data = User::where('phone', $full_phone)
                                    ->orWhere('email', $email)
                                    ->orWhere('id_no', $id_no)
                                    ->first();

            //if user does not exist, create user,
            //else check if company user data exists. if not add company user data

            if (!$user_exists_data) {

                //generate encrypted password
                if (array_key_exists('password', $attributes)) {
                    $attributes['password'] = bcrypt($attributes['password']);
                }
                // get next user cd
                //$attributes['user_cd'] = generate_user_cd();

                // convert phone to standard db phone
                if (array_key_exists('phone', $attributes)) {
                    $phone = $full_phone;
                    $attributes['phone'] = $phone;
                }

                // if its a ussd registration, auto activate user account
                if ((array_key_exists('ussd_reg', $attributes)) && ($attributes['ussd_reg'] == 1)) {
                    $attributes['status_id'] = 1;
                    $attributes['active'] = 1;
                }

                // add user env
                $agent = new \Jenssegers\Agent\Agent;

                $attributes['user_agent'] = serialize($agent);
                $attributes['browser'] = $agent->browser();
                $attributes['browser_version'] = $agent->version($agent->browser());
                $attributes['os'] = $agent->platform();
                $attributes['device'] = $agent->device();
                $attributes['src_ip'] = getIp();
                // end add user env

                //dd($attributes);

                //create user
                try {

                    $user = new User();
                    $model = $user->create($attributes);

                } catch(\Exception $e) {

                    DB::rollback();
                    $message = "An error occured. Could not create user - " . $e->getMessage();
                    return show_json_error($message);
                    //throw new \Exception($e);

                }

            }

        DB::commit();

        return show_json_success($user);

    }

}
