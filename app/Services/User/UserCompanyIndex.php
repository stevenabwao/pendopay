<?php

namespace App\Services\User;

use App\User;
use App\Entities\CompanyUser;
use App\Entities\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Dingo\Api\Exception\StoreResourceFailedException;
use App\Http\Controllers\BaseController;
use App\Transformers\Users\UserTransformer;
use App\Transformers\Company\CompanyTransformer;

class UserCompanyIndex extends BaseController
{

	public function getData($request)
	{

        //dd($request->all());

       // DB::enableQueryLog(); 

        //get data
        $data = new CompanyUser();

        //get params
        $phone = $request->phone;
        $email = $request->email;
        $id_no = $request->id_no;
        $status_id = $request->status_id;

        if (!$phone && !$email && !$id_no) {
            
            $message = 'Please enter user credentials';
            //throw new StoreResourceFailedException($message);

            return show_error($message);

        }

        $order_by = $request->order_by;
        $order_style = $request->order_style;

        //get user id
        //get user id with this phone, email or id_no
        /*
        $user_data = User::where('phone', $phone)
                         ->orWhere('email', $email)
                         ->orWhere('id_no', $id_no)
                         ->first();
                         */

        $user_data = User::where('phone', '!=', '')
                        ->when($phone, function ($query) use ($phone) {
                            $query->where('phone', $phone);
                        })->when($email, function ($query) use ($email) {
                            $query->where('email', $email);
                        })->when($id_no, function ($query) use ($id_no) {
                            $query->where('id_no', $id_no);
                        })->first();

       // print_r(DB::getQueryLog());

        if (!$user_data) {

            $message = 'User does not exist';

            return show_error($message);
            //throw new StoreResourceFailedException($message);

        } else {

            $user_id = $user_data->id;

        }
        //dump($user_data, $user_id);

        $company_ids = $data->where('user_id', $user_id)->pluck('company_id');

        //dd($company_ids);

        //filter results
        $data = new Company();

        if ($status_id) {
            $data = $data->where('status_id', $status_id);
        }

        $data = $data->whereIn('id', $company_ids);

        //order style - either 'desc' or 'asc'
        if (!$order_style) { $order_style = "desc"; }
        if (!$order_by) { $order_by = "id"; }

        //arrange by column
        $data = $data->orderBy($order_by, $order_style);

        $data = $data->get();
        $data = $this->response->collection($data, new CompanyTransformer());

		return $data;

	}

}