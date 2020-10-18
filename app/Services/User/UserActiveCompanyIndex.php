<?php

namespace App\Services\User;

use App\User;
use App\Entities\CompanyUser;
use App\Entities\Company;
use App\Entities\UserSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Dingo\Api\Exception\StoreResourceFailedException;
use App\Http\Controllers\BaseController;

class UserActiveCompanyIndex extends BaseController
{

	public function getData($user_id)
	{

        // dd($request->all());
        // DB::enableQueryLog(); 

        // check if user settings exist
        $new_user_settings_data = UserSetting::where("user_id", $user_id)->first();

        // if settings exist, do an update
        // else create a new record
        if ($new_user_settings_data) {

            // get the company
            $company_id = $new_user_settings_data->active_company_id;

            // return the company data
            $data = Company::find($company_id);

        } else {

            // get the main company record
            try {

                $company_ids = CompanyUser::where('user_id', $user_id)->pluck('company_id');

                $data = Company::whereIn('id', $company_ids)
                                 ->orderBy("id", "desc")
                                 ->first();

            } catch(\Exception $e) {

                DB::rollback();
                // dd($e);
                $message = $e->getMessage();
                log_this($message);
                $show_message['message'] = $message;
                return show_json_error($show_message);

            }

        }

		return $data;

	}

}