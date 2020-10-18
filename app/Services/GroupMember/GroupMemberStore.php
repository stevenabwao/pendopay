<?php

namespace App\Services\GroupMember;

use App\Entities\GroupMember;
use App\Entities\BranchMember;
use App\Entities\BranchGroup;
use App\Entities\CompanyBranch;
use App\Entities\CompanyUser;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;

class GroupMemberStore
{

    use Helpers;

    public function createItem($attributes) {

        DB::beginTransaction();

            $company_branch_id = "";
            $branch_group_id = "";
            $branch_member_id = "";
            
   
            if (array_key_exists('company_branch_id', $attributes)) {
                $company_branch_id = $attributes['company_branch_id'];
            }
            if (array_key_exists('branch_group_id', $attributes)) {
                $branch_group_id = $attributes['branch_group_id'];
            }
            if (array_key_exists('branch_member_id', $attributes)) {
                $branch_member_id = $attributes['branch_member_id'];
            }

            //start check whether member is member of branch being added to
            $branch_member_data = BranchMember::find($branch_member_id);
            $user_company_id = $branch_member_data->company_id;
            $company_user_id = $branch_member_data->company_user_id;

            //branch group
            $branch_group_data = BranchGroup::find($branch_group_id);
            $group_company_id = $branch_group_data->company_id;
            $group_name = $branch_group_data->name;
            $group_branch_name = $branch_group_data->companybranch->name;

            //get branch data
            /*
            $company_branch_data = CompanyBranch::find($company_branch_id);
            $branch_company_id = $company_branch_data->company_id;
            $branch_company_name = $company_branch_data->company->name;
            */

            //dd($branch_group_data, $branch_member_data, $group_branch_name);

            if ($user_company_id != $group_company_id) {
                $message = "Error. Please select a user from branch - " . $group_branch_name;
                $response["message"] = $message;
                return show_json_error($response);
            }
            //end check whether member is member of company being added to

            //start check if group member exists
            $group_member_data = GroupMember::where('branch_group_id', $branch_group_id)
                                 ->where('branch_member_id', $branch_member_id)
                                 ->first();

            //dd($group_member_data);

            //if company record already exists, throw an error
            if ($group_member_data) {
                $message = "Group Member already exists in group - $group_name!!!";
                $response["message"] = $message;
                return show_json_error($response);
            }
            //end check if company data exists

            if (!$group_member_data) {

                //get company id
                $company_branch_data = CompanyBranch::find($company_branch_id);
                $company_id = $company_branch_data->company_id;

                $attributes['company_id'] = $company_id;

                $attributes['company_user_id'] = $company_user_id;                

                //start create new local Company Branch
                try {

                    $new_branch_member = new GroupMember();

                    //dd($attributes);

                    $result = $new_branch_member->create($attributes);

                    //dd($result);

                    log_this(">>>>>>>>> SNB SUCCESS CREATING GROUP MEMBER :\n\n" . json_encode($result) . "\n\n\n");
                    $response["message"] = $result;

                } catch(\Exception $e) {

                    DB::rollback();
                    $message = $e->getMessage();
                    //throw new StoreResourceFailedException($e->getMessage());
                    log_this(">>>>>>>>> SNB ERROR CREATING GROUP MEMBER :\n\n" . $message . "\n\n\n");
                    $response["message"] = $message;
                    return show_json_error($response);

                }
                //end create new local Company


            }


        DB::commit();

        return show_json_success($response);

    }

}
