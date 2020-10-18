<?php

namespace App\Services\BranchMember;

use App\Entities\BranchMember;
use App\Entities\GroupMember;
use App\Entities\CompanyBranch;
use App\Entities\CompanyUser;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BranchMemberStore
{

    use Helpers;

    public function createItem($attributes) {

        DB::beginTransaction();

            $company_branch_id = "";
            $company_user_id = "";
            
   
            if (array_key_exists('company_branch_id', $attributes)) {
                $company_branch_id = $attributes['company_branch_id'];
            }
            if (array_key_exists('company_user_id', $attributes)) {
                $company_user_id = $attributes['company_user_id'];
            }

            //start check whether member is member of company being added to
            $company_user_data = CompanyUser::find($company_user_id);
            $user_company_id = $company_user_data->company_id;

            //get branch data
            $company_branch_data = CompanyBranch::find($company_branch_id);
            $branch_company_id = $company_branch_data->company_id;
            $branch_company_name = $company_branch_data->company->name;
            //dd($branch_company_id, $branch_company_name, $user_company_id);

            if ($user_company_id != $branch_company_id) {
                $message = "Error. Please select a user from " . $branch_company_name;
                $response["message"] = $message;
                return show_json_error($response);
            }
            //end check whether member is member of company being added to

            //start check if branch member exists
            $branch_member_data = BranchMember::where('company_branch_id', $company_branch_id)
                                 ->where('company_user_id', $company_user_id)
                                 ->first();

            //dd($company_id);

            //if company record already exists, throw an error
            if ($branch_member_data) {
                $message = "Branch Member already exists!!!";
                $response["message"] = $message;
                return show_json_error($response);
                //throw new StoreResourceFailedException('Company name already exists!!!');
            }
            //end check if company data exists

            if (!$branch_member_data) {

                //get company id
                $company_branch_data = CompanyBranch::find($company_branch_id);
                $company_id = $company_branch_data->company_id;

                $attributes['company_id'] = $company_id;
                                 

                //start create new local Company Branch
                try {

                    $new_branch_member = new BranchMember();

                    //dd($attributes);

                    $result = $new_branch_member->create($attributes);

                    //dd($result);

                    log_this(">>>>>>>>> SNB SUCCESS CREATING BRANCH MEMBER :\n\n" . json_encode($result) . "\n\n\n");
                    $response["message"] = $result;

                } catch(\Exception $e) {

                    DB::rollback();
                    $message = $e->getMessage();
                    //throw new StoreResourceFailedException($e->getMessage());
                    log_this(">>>>>>>>> SNB ERROR CREATING BRANCH MEMBER :\n\n" . $message . "\n\n\n");
                    $response["message"] = $message;
                    return show_json_error($response);

                }
                //end create new local Company


            }


        DB::commit();

        return show_json_success($response);

    }

}
