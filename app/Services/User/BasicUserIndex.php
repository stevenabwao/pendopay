<?php

namespace App\Services\User;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BasicUserIndex
{

	public function getData($request)
	{

        //get data
        $data = new User();

        //get params
        $id = $request->id;
        $phone = $request->phone;
        $email = $request->email;
       
        //filter results
        if ($id) {
            $data = $data->where('id', $id);
        }
        if ($phone) {
            $db_phone = getDatabasePhoneNumber($phone);
            $data = $data->where('phone', $db_phone);
        }
        if ($email) {
            $data = $data->where('email', $email);
        }

        $data = $data->first();

		return $data;

	}

}