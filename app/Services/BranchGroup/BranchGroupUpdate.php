<?php

namespace App\Services\BranchGroup;

use App\Entities\BranchGroup;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BranchGroupUpdate 
{

    use Helpers;

    public function updateItem($id, $attributes) {

        DB::beginTransaction();

        $name = "";
        $company_id = "";
        $physical_address = "";
        $manager_id = "";
        $box = "";
        $email = "";
        $phone = "";
        $phone_country = "";
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
        if (array_key_exists('email', $attributes)) {
            $email = $attributes['email'];
        }
        if (array_key_exists('status_id', $attributes)) {
            $status_id = $attributes['status_id'];
        } 

        //get phone data
        try{
            $localised_phone = getDatabasePhoneNumber($phone, $phone_country);
        } catch (\Exception $e) {
            $message = "Error evaluating phone number - " . $e->getMessage();
            $response["message"] = $message;
            return show_json_error($response);
        }

        //start check if company branch data exists
        $company_branch_group_data = BranchGroup::find($id);

        //if company record already exists, throw an error
        if (!$company_branch_group_data) {
            $message = "Company branch does not exists!!!";
            $response["message"] = $message;
            return show_json_error($response);
        }
        //end check if company data exists


        if ($company_branch_group_data) {

            //start update Company Branch
            try {

                $new_company_branch_group = new BranchGroup();

                //convert phone to standard local phone
                if (array_key_exists('phone', $attributes)) {
                    $phone = $localised_phone;
                    $attributes['phone'] = $phone;
                }

                //dump($attributes);

                $result = $new_company_branch_group->updatedata($id, $attributes);

                //dd($result);

                log_this(">>>>>>>>> SNB SUCCESS UPDATING COMPANY BRANCH :\n\n" . json_encode($result) . "\n\n\n");
                $response["message"] = $result;

            } catch(\Exception $e) {

                DB::rollback();
                $message = $e->getMessage();
                //throw new StoreResourceFailedException($e->getMessage());
                log_this(">>>>>>>>> SNB ERROR UPDATING COMPANY BRANCH :\n\n" . $message . "\n\n\n");
                $response["message"] = $message;
                return show_json_error($response);

            }
            //end create new local Company

        } 

        DB::commit();

        return show_json_success($response);

    }

}
