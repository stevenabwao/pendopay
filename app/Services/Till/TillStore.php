<?php

namespace App\Services\Till;

use App\Entities\Till;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TillStore
{

    public function createItem($attributes) {

        DB::beginTransaction();

        $response = [];

        $till_number = "";
        $company_id = "";
        $till_name = "";
        $phone_number = "";

        if (array_key_exists('till_number', $attributes)) {
            $till_number = $attributes['till_number'];
        }
        if (array_key_exists('company_id', $attributes)) {
            $company_id = $attributes['company_id'];
        }
        if (array_key_exists('till_name', $attributes)) {
            $till_name = $attributes['till_name'];
        }
        if (array_key_exists('phone_number', $attributes)) {
            $phone_number = $attributes['phone_number'];
        }

        // convert phone number
        $phone_number = getDatabasePhoneNumber($phone_number);
        $attributes['phone_number'] = $phone_number;

        // check if till number already exists in company
        if (tillExistsForCompany($till_number, $company_id)) {
            $company_data = getCompanyData($company_id);
            $message = "Till $till_number already exists for company";
            if ($company_data) {
                $message .= " $company_data->name";
            }
            $response["message"] = $message;
            return show_json_error($response);
        }

        // check if phone till already exists in company
        $company_name = "";
        $company_data = getCompanyData($company_id);
        if ($company_data) {
            $company_name = $company_data->name;
        }

        if (phoneTillExistsForCompany($phone_number, $company_id)) {

            $message = "Phone $phone_number till already exists for company";
            if ($company_name) {
                $message .= " $company_name";
            }
            $response["message"] = $message;
            return show_json_error($response);
        }

        //save new record
        try {

            $new_till = new Till();
            $result = $new_till->create($attributes);

            log_this(">>>>>>>>> SNB SUCCESS CREATING TILL :\n\n" . json_encode($result) . "\n\n\n");

            if ($result) {

                // send sms to recipient phone
                // generate random link and save it to db
                $confirm_code = generateCode(5, false, 'lud');
                $phone_country = getPhoneCountry();
                $site_url = getSiteUrl();

                // create sms message
                $activation_link = $site_url . "/tills/actv/" . $confirm_code;
                $sms_message = "Dear member, your phone number has been added as till no. $till_number ";
                $sms_message .= "for establishment $company_name, click the link below or copy link to your browser ";
                $sms_message .= "to confirm your phone number: \n";
                $sms_message .= $activation_link;

                // send phone number confirm code
                $sms_type_id = config('constants.sms_types.confirmation_sms');
                createPhoneConfirmCode($confirm_code, $phone_number, $phone_country, $company_id, $sms_type_id, $sms_message);

                $response["message"] = "Till successfully created";

            } else {

                $response["message"] = "Could not create till. " . json_encode($result);
                return show_json_error($response);

            }

            $response = show_json_success($response);

         } catch(\Exception $e) {

            //dd($e);
            DB::rollback();
            $message = $e->getMessage();
            return show_json_error($message);

        }

        DB::commit();

        return $response;

    }

}
