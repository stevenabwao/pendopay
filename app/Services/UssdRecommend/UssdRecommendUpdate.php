<?php

namespace App\Services\UssdRecommend;

use App\UssdRecommend;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UssdRecommendUpdate
{

    use Helpers;

    public function updateItem($id, $attributes) {

        DB::beginTransaction();

            //get company data
            $name = $attributes['name'];
            $phone = $attributes['phone'];
            $phone_country = $attributes['phone_country'];
            $localised_phone = getLocalisedPhoneNumber($phone, $phone_country);

            //start check if company data exists
            $company_data = Company::where('name', $name)->first();

            //if company record already exists, throw an error
            if (!$company_data) {
                throw new StoreResourceFailedException('Company does not exist!!!');
            }
            //end check if company data exists

            if ($company_data) {

                //update company
                try {

                    if (array_key_exists('sms_user_name', $attributes)) {
                        $remove_spaces_regex = "/\s+/";
                        //remove all spaces
                        $sms_user_name = preg_replace($remove_spaces_regex, '', $attributes['sms_user_name']);
                        $attributes['sms_user_name'] = $sms_user_name;
                    }

                    //convert phone to standard local phone
                    if (array_key_exists('phone', $attributes)) {
                        $phone = $localised_phone;
                        $attributes['phone'] = $phone;
                    }

                    $company = new Company();

                    $company_result = $company->updatedata($id, $attributes);

                } catch(\Exception $e) {

                    DB::rollback();
                    throw new StoreResourceFailedException($e);

                }

            }


        DB::commit();

        return $company_result;

    }

}
