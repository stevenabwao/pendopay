<?php

namespace App\Services\BranchGroup;

use App\Entities\BranchGroup;
use App\Entities\CompanyBranch;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BranchGroupStore
{

    use Helpers;

    public function createItem($attributes) {

        DB::beginTransaction();

            $name = "";
            $company_branch_id = "";
            $primary_user_id = "";
            $box = "";
            $email = "";
            $phone = "";
            $phone_country = "";
            $physical_address = "";
            $email = "";
            $status_id = "";

   
            if (array_key_exists('name', $attributes)) {
                $name = $attributes['name'];
            }
            if (array_key_exists('company_branch_id', $attributes)) {
                $company_branch_id = $attributes['company_branch_id'];
            }
            if (array_key_exists('phone', $attributes)) {
                $phone = $attributes['phone'];
            }
            if (array_key_exists('physical_address', $attributes)) {
                $physical_address = $attributes['physical_address'];
            }
            if (array_key_exists('primary_user_id', $attributes)) {
                $primary_user_id = $attributes['primary_user_id'];
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
            $branch_group_data = BranchGroup::where('name', $name)->first();

            //get company id
            //get company branch
            $company_branch_data = CompanyBranch::find($company_branch_id);
            //dd($attributes, $company_branch_data);
            $company_id = $company_branch_data->company->id;

            //dd($company_id);

            //if company record already exists, throw an error
            if ($branch_group_data) {
                $message = "Branch Group name already exists!!!";
                $response["message"] = $message;
                return show_json_error($response);
                //throw new StoreResourceFailedException('Company name already exists!!!');
            }
            //end check if company data exists

            if (!$branch_group_data) {

                //start create new local Company Branch
                try {

                    $new_branch_group = new BranchGroup();

                    //convert phone to standard local phone
                    if (array_key_exists('phone', $attributes)) {
                        $phone = $localised_phone;
                        $attributes['phone'] = $phone;
                    }
                    
                    $attributes['company_id'] = $company_id;

                    //dd($attributes);

                    $result = $new_branch_group->create($attributes);

                    //dd($result);

                    log_this(">>>>>>>>> SNB SUCCESS CREATING BRANCH GROUP :\n\n" . json_encode($result) . "\n\n\n");
                    $response["message"] = $result;

                } catch(\Exception $e) {

                    DB::rollback();
                    $message = $e->getMessage();
                    //throw new StoreResourceFailedException($e->getMessage());
                    log_this(">>>>>>>>> SNB ERROR CREATING BRANCH GROUP :\n\n" . $message . "\n\n\n");
                    $response["message"] = $message;
                    return show_json_error($response);

                }
                //end create new local Company


            }


        DB::commit();

        return show_json_success($response);

    }

}
