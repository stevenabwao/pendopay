<?php

namespace App\Services\UserSetting;

use App\Entities\UserSetting;
use App\Entities\Company;
use Illuminate\Support\Facades\DB;

class UserSettingStore
{

    public function createItem($request) {

        // dd($attributes);
        $user_id = null;
        $username = "";
        $active_company_id = null;
        $settings_type = null;
        $target_id = null;
        $dark_theme = null;
        $color = "";
        $mini_sidebar = null;
   
        if ($request->has('user_id')) {
            $user_id = $request->user_id;
        }
        if ($request->has('username')) {
            $username = $request->username;
        }
        if ($request->has('active_company_id')) {
            $active_company_id = $request->active_company_id;
        }
        if ($request->has('settings_type')) {
            $settings_type = $request->settings_type;
        }
        if ($request->has('target_id')) {
            $target_id = $request->target_id;
        }
        if ($request->has('dark_theme')) {
            $dark_theme = $request->dark_theme;
        }
        if ($request->has('color')) {
            $color = $request->color;
        }
        if ($request->has('mini_sidebar')) {
            $mini_sidebar = $request->mini_sidebar;
        }

        DB::beginTransaction();

            // check if user settings exist
            $new_user_settings_data = UserSetting::where("user_id", $user_id)->first();

            // if settings exist, do an update
            // else create a new record
            if ($new_user_settings_data) {

                // update record
                // set fields
                $new_user_settings_data->active_company_id = $active_company_id;
                $new_user_settings_data->settings_type = $settings_type;
                $new_user_settings_data->target_id = $target_id;
                $new_user_settings_data->dark_theme = $dark_theme;
                $new_user_settings_data->color = $color;
                $new_user_settings_data->mini_sidebar = $mini_sidebar;

                $new_user_settings_data->save();

                $response['data'] = $new_user_settings_data;
                $response['message'] = "User settings updated successfully";

            } else {

                //save new userSettings record
                try {

                    //create new item
                    $user_setting = new UserSetting();

                    log_this("UserSetting attributes -" . json_encode($request->all()));

                    $response['data'] = $user_setting->create($request->all());
                    $response['message'] = "User settings stored successfully";

                } catch(\Exception $e) {

                    DB::rollback();
                    // dd($e);
                    $message = $e->getMessage();
                    log_this($message);
                    $show_message['message'] = $message;
                    return show_json_error($show_message);

                }

            }

            //return final result
            $response = show_json_success($response);

        DB::commit();


        return $response;


    }

}