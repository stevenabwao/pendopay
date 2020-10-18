<?php

namespace App\Services\CompanyBranch;

use App\Entities\CompanyBranch;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CompanyBranchStore
{

    use Helpers;

    public function createItem($attributes) {

        DB::beginTransaction();

            $name = "";
            $company_id = "";
            $physical_address = "";
            $manager_id = "";
            $box = "";
            $email = "";
            $phone = "";
            $phone_country = "";
            $email = "";
            $status_id = "";

   
            if (array_key_exists('name', $attributes)) {
                $name = $attributes['name'];
            }
            if (array_key_exists('phone', $attributes)) {
                $phone = $attributes['phone'];
            }
            if (array_key_exists('phone_country', $attributes)) {
                $phone_country = $attributes['phone_country'];
            }
            if (array_key_exists('company_id', $attributes)) {
                $company_id = $attributes['company_id'];
            }
            if (array_key_exists('physical_address', $attributes)) {
                $physical_address = $attributes['physical_address'];
            }
            if (array_key_exists('manager_id', $attributes)) {
                $manager_id = $attributes['manager_id'];
            }
            if (array_key_exists('box', $attributes)) {
                $box = $attributes['box'];
            }
            if (array_key_exists('phone_country', $attributes)) {
                $phone_country = $attributes['phone_country'];
            } 
            if (array_key_exists('email', $attributes)) {
                $email = $attributes['email'];
            }
            if (array_key_exists('status_id', $attributes)) {
                $status_id = $attributes['status_id'];
            } 

            //get company data
            try{
                $localised_phone = getDatabasePhoneNumber($phone, $phone_country);
            } catch (\Exception $e) {
                $message = "Error evaluating phone number - " . $e->getMessage();
                $response["message"] = $message;
                return show_json_error($response);
                //throw new StoreResourceFailedException($e->getMessage());
            }

            //start check if company data exists
            $company_branch_data = CompanyBranch::where('name', $name)->first();

            //if company record already exists, throw an error
            if ($company_branch_data) {
                $message = "Company Branch name already exists!!!";
                $response["message"] = $message;
                return show_json_error($response);
                //throw new StoreResourceFailedException('Company name already exists!!!');
            }
            //end check if company data exists

            if (!$company_branch_data) {

                
                //start create new remote Company branch
                /*
                try {

                    $new_pendo_company_url = config('constants.pendoapi_urls.companies_url');

                    $pendoapi_app_name = config('constants.settings.pendoapi_app_name');
                    //get app access token
                    $access_token = getAdminAccessToken($pendoapi_app_name);

                    if ($access_token) {

                        //set params
                        $params = [
                            'json' => [
                                'name' => $name,
                                'description' => $description,
                                'physical_address' => $physical_address,
                                'ussd_code' => $ussd_code,
                                'box' => $box,
                                'sms_user_name' => $sms_user_name,
                                'phone' => $phone,
                                'phone_country' => $phone_country,
                                'ussd' => $ussd,
                                'email' => $email,
                                'latitude' => $latitude,
                                'longitude' => $longitude
                            ]
                        ];

                        //start create new company
                        $json_response = sendAuthPostApi($new_pendo_company_url, $access_token, $params);

                        $json_response = json_decode($json_response);

                        log_this(">>>>>>>>> SNB CREATE NEW COMPANY API RESULT :\n\n" . json_encode($json_response) . "\n\n\n");

                        if (!$json_response->error) {

                            $company_result = $json_response->message;
                            
                        } else {

                            $message = $json_response->message;
                            //dd($message);
                            DB::rollback();
                            log_this(">>>>>>>>> SNB ERROR CREATING COMPANY VIA API :\n\n" . $message . "\n\n\n");
                            //throw new StoreResourceFailedException($message);
                            $response["error"] = true;
                            $response["message"] = $message;
                            return json_encode($response);

                        }

                    } else {

                        DB::rollback();
                        $message = "An error occured";
                        log_this(">>>>>>>>> SNB ERROR CREATING COMPANY VIA API :\n\n" . $message . "\n\n\n");
                        //throw new StoreResourceFailedException($message);
                        $response["error"] = true;
                        $response["message"] = $message;
                        return json_encode($response);

                    }
                    

                } catch(\Exception $e) {

                    DB::rollback();
                    $message = $e->getMessage();
                    //throw new StoreResourceFailedException($e->getMessage());
                    log_this(">>>>>>>>> SNB ERROR CREATING COMPANY VIA API :\n\n" . $message . "\n\n\n");
                    $response["error"] = true;
                    $response["message"] = $message;
                    return json_encode($response);

                }
                */
                //end create new remote Company


                //start create new local Company Branch
                try {

                    $new_company_branch = new CompanyBranch();

                    //convert phone to standard local phone
                    if (array_key_exists('phone', $attributes)) {
                        $phone = $localised_phone;
                        $attributes['phone'] = $phone;
                    }
                    //$attributes['id'] = $company_result->id;

                    //dump($attributes);

                    $result = $new_company_branch->create($attributes);

                    //dd($result);

                    log_this(">>>>>>>>> SNB SUCCESS CREATING COMPANY BRANCH :\n\n" . json_encode($result) . "\n\n\n");
                    $response["message"] = $result;

                } catch(\Exception $e) {

                    DB::rollback();
                    $message = $e->getMessage();
                    //throw new StoreResourceFailedException($e->getMessage());
                    log_this(">>>>>>>>> SNB ERROR CREATING COMPANY BRANCH :\n\n" . $message . "\n\n\n");
                    $response["message"] = $message;
                    return show_json_error($response);

                }
                //end create new local Company


            }


        DB::commit();

        return show_json_success($response);

    }

}
