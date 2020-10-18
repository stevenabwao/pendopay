<?php

namespace App\Services\UssdRecommend;

use App\Entities\UssdRecommend;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UssdRecommendStore
{

    use Helpers;

    public function createItem($attributes) {

        DB::beginTransaction();

            $phone = "";
            $rec_phone = "";
            $rec_name = "";
            $full_name = "";
            $company_id = "";

            if (array_key_exists('phone', $attributes)) {
                $phone = $attributes['phone'];
            }
            if (array_key_exists('rec_phone', $attributes)) {
                $rec_phone = $attributes['rec_phone'];
            }
            if (array_key_exists('rec_name', $attributes)) {
                $rec_name = $attributes['rec_name'];
            }
            if (array_key_exists('full_name', $attributes)) {
                $full_name = $attributes['full_name'];
            }
            if (array_key_exists('company_id', $attributes)) {
                $company_id = $attributes['company_id'];
            }

            //start get phone data
            try{

                $phone = getDatabasePhoneNumber($phone);
                $attributes['phone'] = $phone;

            } catch (\Exception $e) {

                $message = "Error evaluating sender phone number";
                log_this($message . ' - ' . $e->getMessage());
                $response["error"] = true;
                $response["message"] = $message;
                return json_encode($response);

            }
            //end get phone data

            //start get rec_phone data
            try{

                $rec_phone = getDatabasePhoneNumber($rec_phone);
                $attributes['rec_phone'] = $rec_phone;

            } catch (\Exception $e) {

                $message = "Error evaluating recipient phone number";
                log_this($message . ' - ' . $e->getMessage());
                $response["error"] = true;
                $response["message"] = $message;
                return json_encode($response);

            }
            //end get rec_phone data

            //start create new USSD RECOMMEND
            try {

                $new_ussd_recommend = new UssdRecommend();
                $result = $new_ussd_recommend->create($attributes);
                //dd($result);
                log_this(">>>>>>>>> SNB SUCCESS CREATING USSD RECOMMEND VIA API :\n\n" . json_encode($result) . "\n\n\n");
                $response["error"] = false;
                $response["message"] = $result;

                //get company ussd code
                $company_data = getCompanyPaybillData($company_id);
                $company_data = json_decode($company_data);
                $company_data = $company_data->data;
                //dd($company_data);
                $company_ussd_code = $company_data->ussd_code;
                $company_short_name = $company_data->short_name;

                //start send recommend sms
                $sms_type_id = config('constants.sms_types.recommendation_sms');
                $local_phone = getLocalisedPhoneNumber($phone);
                $message = "Dear $rec_name, your friend $full_name of $local_phone";
                $message .= " has recommended you to join $company_short_name. ";
                $message .= "\nDial *533*$company_ussd_code# to register.";
                $result = createSmsOutbox($message, $rec_phone, $sms_type_id, $company_id);
                log_this(">>>>>>>>> SNB SUCCESS CREATING USSD RECOMMEND SMS VIA API :\n\n" . json_encode($result) . "\n\n\n");
                //end send recommend sms

            } catch(\Exception $e) {

                DB::rollback();
                $message = $e->getMessage();
                //throw new StoreResourceFailedException($e->getMessage());
                log_this(">>>>>>>>> SNB ERROR CREATING USSD RECOMMEND SMS VIA API :\n\n" . $message . "\n\n\n");
                $response["error"] = true;
                $response["message"] = $message;
                return json_encode($response);

            }
            //end create new USSD RECOMMEND


        DB::commit();

        return json_encode($response);

    }

}
