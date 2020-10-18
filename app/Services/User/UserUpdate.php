<?php

namespace App\Services\User;

use App\Entities\Account;
use App\Entities\Company;
use App\Entities\CompanyUser;
use App\Services\User\UserCompanyStore;
use App\User;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserUpdate
{

    use Helpers;

    public function updateItem($id, $request) {

        //dd($request->all());

        //current date and time
        $date = Carbon::now();
        $date = getLocalDate($date);
        $date = $date->toDateTimeString();


        DB::beginTransaction();


            //get data
            /* $first_name = "";
            $last_name = "";
            $email = "";
            $company_id = "";
            $gender = "";
            $phone = ""; */

            /* if ($request->has('first_name')) {
                $data->appends('first_name', $request->get('first_name'));
            }
            if ($request->has('last_name')) {
                $data->appends('last_name', $request->get('last_name'));
            }
            if ($request->has('email')) {
                $data->appends('email', $request->get('email'));
            }
            if ($request->has('company_id')) {
                $data->appends('company_id', $request->get('company_id'));
            }
            if ($request->has('gender')) {
                $data->appends('gender', $request->get('gender'));
            }
            if ($request->has('phone')) {
                $data->appends('phone', $request->get('phone'));
            } */

            /* //get phone number
            if ($phone_country) {
                $full_phone = getDatabasePhoneNumber($phone, $phone_country);
            } else {
                $full_phone = getDatabasePhoneNumber($phone);
            } */

            //start check if company exists

            $email = "";
            $company_short_name = "";
            $password = "";

            try {
                
                $phone = '';
                $phone = getDatabasePhoneNumber($request->phone);

                $company_user_data = CompanyUser::findOrFail($id);

                $user = User::findOrFail($company_user_data->user_id);

                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->email = $request->email;
                $user->company_id = $request->company_id;
                $user->phone = $phone;
                $is_company_user = $company_user_data->is_company_user;
                //$user->account_number = $request->account_number;
                $user->gender = $request->gender;

                

                //get companydata
                $company_data = Company::find($company_user_data->company_id);
                $company_name = $company_data->name;
                $company_short_name = $company_data->short_name;

                if ($request->password_option == 'auto'){
                    /*auto generate new password*/
                    $password = generateCode(6);
                    $user->password = bcrypt($password);
                    //send the user a link to change password

                } else if ($request->password_option == 'manual'){
                    /*set to entered password*/
                    $user->password = bcrypt($request->password);
                }

                if ($user->save()) {

                    if ($request->rolesSelected) {
                        //sync roles
                        $user->syncRoles(explode(',', $request->rolesSelected));
                    }
                    if ($request->groupsSelected) {
                        //sync groups
                        $groups = explode(',', $request->groupsSelected);
                        $user->groups()->sync($groups);
                    }

                    //send the user an email
                    //is a company user send email
                    $email = $user->email;
                    $company_id = $user->company_id;
                    $first_name = $user->first_name;
                    $last_name = $user->last_name;
                    $phone = $user->phone;
                    $is_company_user = $company_user_data->is_company_user;
                    $password = $request->password;
                    //dd("hapaaa", $password);

                    if (($email) && (isEmailOk($email, $company_id))) {

                        if ($is_company_user == "1") {
                            $subject = 'Dear ' . $first_name . ', Your ' . $company_short_name . ' account has been created ';
                        } else {
                            $subject = 'Dear ' . $first_name . ', Your password at ' . $company_short_name . ' has been created ';
                        }
                        $title = $subject;
    
                        $email_salutation = "Dear " . $first_name . ",<br><br>";
    
                        if ($is_company_user == "1") {
                            $email_text = "Your company account has been created in $company_name.<br><br>";
                            $email_text .= "Your account details are as follows: <br><br>";
                        } else {
                            $email_text = "Your $company_name account password has been changed.<br><br>";
                            $email_text .= "Your account details are as follows: <br><br>";
                        }
    
                        $panel_text = "Full Name: <strong>$first_name $last_name</strong><br>";
                        $panel_text .= "Email: $email<br>";
                        $panel_text .= "Phone: <strong>$phone</strong><br><br>";
                        $panel_text .= "Password: $password<br><br>";
    
                        $email_text .= "(NB: Please login to your account and change the password) <br><br>";
    
                        $email_footer = "Regards,<br>";
                        $email_footer .= "$company_short_name Management";
    
                        //email queue
                        $table_text = "";
    
                        $parent_id = 0;
                        $reminder_message_id = 0;
                        $has_attachments = "99";
                        $event_type_id = NULL;
    
                        $result = sendTheEmailToQueue($email, $subject, $title, $company_name, $email_text, $email_salutation,
                            $company_id, $email_footer, $panel_text, $table_text, $parent_id,
                            $reminder_message_id, $has_attachments, $event_type_id);
    
                    }

                    $response["message"] = "User successfully updated";

                } else {

                    $message = "There ws an error saving the update";
                    return show_json_error($message);

                }

            } catch(\Exception $e) {

                dd($e);
                DB::rollback();
                //throw new StoreResourceFailedException('Error fetching company record');
                $message = "Error fetching company record";
                return show_json_error($message);

            }
            //end check if company exists

        DB::commit();

        //return show_json_success($company_user);
        return show_json_success($response);

    }

}
