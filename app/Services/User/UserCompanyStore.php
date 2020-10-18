<?php

namespace App\Services\User;

use App\Entities\Account;
use App\Entities\Company;
use App\Entities\CompanyUser;
use App\User;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserCompanyStore
{

    use Helpers;

    public function createItem($attributes, $user_id) {

        DB::beginTransaction();

            if (auth()->user()) {
                $created_by = auth()->user()->id;
                $updated_by = auth()->user()->id;
            } else {
                $created_by = $user_id;
                $updated_by = $user_id;
            }

            $company_id = $attributes['company_id'];

            //start create company user 
            try {

                //if not member, add user to company list
                $company_user = new CompanyUser();
                $company_user_attributes['company_id'] = $attributes['company_id'];
                $company_user_attributes['user_id'] = $user_id;
                $company_user_attributes['ussd_reg'] = $attributes['ussd_reg'];
                $company_user_attributes['created_by'] = $created_by;
                $company_user_attributes['updated_by'] = $updated_by;
                $company_user_attributes['user_cd'] = generate_user_cd();

                //if its a ussd registration, auto activate user account
                if ((array_key_exists('ussd_reg', $attributes)) && ($attributes['ussd_reg'] == 1)) {
                    $company_user_attributes['status_id'] = 1;
                }

                //dd($company_user_attributes);

                $new_company_user = $company_user->create($company_user_attributes);

            } catch(\Exception $e) { 

                DB::rollback();
                //$message = "Could not create company user";
                throw new StoreResourceFailedException($e);
                //return show_error($message);

            }
            //end create company user


        DB::commit();


        return $new_company_user;

    }

}
