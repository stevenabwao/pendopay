<?php

namespace App\Services\CompanyUser;

use App\User;
use App\Entities\CompanyUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Dingo\Api\Exception\StoreResourceFailedException;

class CompanyCheckUser
{

	public function getData($request)
	{

        //get data
        $data = new CompanyUser();

        //get params
        $phone = $request->phone;
        $company_id = $request->company_id;

        //get user id with this phone
        $user_data = User::where('phone', $phone)->first();

        if (!$user_data) {
            $message = 'User does not exist';
            //throw new StoreResourceFailedException($message);
            return show_error($message);
        } else {
            $user_id = $user_data->id;
        }
        
        //filter results
        $data = $data->where('user_id', $user_id)
                     ->where('company_id', $company_id)
                     ->first();   
                    
        if ($data) {
            $message =  ['message' => 'User exists', 'status_code' => '200', 'user'=> $data->user];
        } else {
            $message = 'User does not exist';
            //throw new StoreResourceFailedException($message);
            return show_error($message);
        }

		return $message;

	}

}