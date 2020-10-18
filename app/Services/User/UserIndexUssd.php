<?php

namespace App\Services\User;

use App\User;
use App\Entities\CompanyUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UserIndexUssd
{

	public function getUsers($request)
	{

        //DB::enableQueryLog(); 
        $companies_num_array = getUserCompanyIds($request);


        //get data
        $data = new User();
        $data = $data->with('roles.permissions')
                ->with('companies')
                ->with('images');

        //get params
        $report = $request->report;
        $id = $request->id;
        $account_search = $request->account_search;
        $phone = $request->phone;
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $id_no = $request->id_no;
        $email = $request->email;
        $companies = $request->companies;
        $status_id = $request->status_id;
        $created_by = $request->created_by;
        $updated_by = $request->updated_by;

        $order_by = $request->order_by;
        $order_style = $request->order_style;

        $start_date = $request->start_date;
        if ($start_date) {
            $start_date = Carbon::parse($request->start_date);
            $start_date = $start_date->startOfDay();
        }
        $end_date = $request->end_date;
        if ($end_date) {
            $end_date = Carbon::parse($request->end_date);
            $end_date = $end_date->endOfDay();
        }

        if ($account_search) {
            $account_search_values = getSplitTerms($account_search); 
            $data = $data->where('id_no', "LIKE", '%' . $account_search . '%')
                         ->orWhere('email', "LIKE", '%' . $account_search . '%')
                         ->orWhere('phone', "LIKE", '%' . $account_search . '%')
                         ->orWhere('first_name', "LIKE", '%' . $account_search . '%')
                         ->orWhere('last_name', "LIKE", '%' . $account_search . '%')
                         ->orWhere(function ($q) use ($account_search_values) {
                            foreach ($account_search_values as $value) {
                                $q->orWhere('id_no', 'LIKE', "%{$value}%");
                                $q->orWhere('email', 'LIKE', "%{$value}%");
                                $q->orWhere('phone', 'LIKE', "%{$value}%");
                                $q->orWhere('first_name', 'LIKE', "%{$value}%");
                                $q->orWhere('last_name', 'LIKE', "%{$value}%");
                            }
                         });
        }

        if (count($companies_num_array)) {
            $data = $data->whereIn('company_id', $companies_num_array);
        }
        //dd("companies_num_array", $companies_num_array);

        //filter results
        if ($id) {
            $data = $data->where('id', $id);
        }
        /*if ($company_id) {
            $data = $data
                        ->join('company_user', 'users.id','=','company_user.user_id')
                        ->join('companies','companies.id','=','company_user.company_id')
                        ->where('companies.id', $company_id);
        }*/
        if ($status_id) {
            $data = $data->where('status_id', $status_id);
        }
        if ($phone) {
            $local_phone = getDatabasePhoneNumber($phone);
            $data = $data->where('phone', $local_phone);
        }
        if ($email) {
            $data = $data->where('email', $email);
        }
        if ($created_by) {
            $data = $data->where('created_by', $created_by);
        }
        if ($updated_by) {
            $data = $data->where('updated_by', $updated_by);
        }
        if ($start_date) {
            $data = $data->where('created_at', '>=', $start_date);
        }
        if ($end_date) {
            $data = $data->where('created_at', '<=', $end_date);
        }

        //$data = $data->where('is_admin', '!=', '1');

        //order style - either 'desc' or 'asc'
        if (!$order_style) { $order_style = "desc"; }
        if (!$order_by) { $order_by = "id"; }

        //arrange by column
        $data = $data->orderBy($order_by, $order_style);

        //dd(DB::getQueryLog());

        //are we in report mode?
        //if not, set url appended params
        if (!$report) {

            $limit = $request->get('limit', config('app.pagination_limit'));
            $data = $data->paginate($limit);

            //add query params
            if ($request->has('order_by')) {
                $data->appends('order_by', $request->get('order_by'));
            }
            if ($request->has('order_style')) {
                $data->appends('order_style', $request->get('order_style'));
            }
            if ($request->has('status_id')) {
                $data->appends('status_id', $request->get('status_id'));
            }
            if ($request->has('phone')) {
                $data->appends('phone', $request->get('phone'));
            }
            if ($request->has('email')) {
                $data->appends('email', $request->get('email'));
            }
            if ($request->has('created_by')) {
                $data->appends('created_by', $request->get('created_by'));
            }
            if ($request->has('updated_by')) {
                $data->appends('updated_by', $request->get('updated_by'));
            }
            //end query params
        }

		return $data;

	}

}