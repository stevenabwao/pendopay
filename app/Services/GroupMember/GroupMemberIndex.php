<?php

namespace App\Services\GroupMember;

use App\Entities\GroupMember;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GroupMemberIndex 
{

	public function getData($request)
	{

        //DB::enableQueryLog();

        $companies_num_array = getUserCompanyIds($request);

        //create data object
        $data = new GroupMember();

        //get params
        $report = $request->report;
        $id = $request->id;
        $company_branch_id = $request->company_branch_id;
        $primary_user_id = $request->primary_user_id;
        $company_id = $request->company_id;
        $email = $request->email;
        $phone = $request->phone;
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

        //filter results
        if ($id) {
            $data = $data->where('id', $id);
        }
        if ($company_branch_id) {
            $data = $data->where('company_branch_id', $company_branch_id);
        }
        if (count($companies_num_array)) {
            $data = $data->whereIn('company_id', $companies_num_array);
        }
        if ($primary_user_id) {
            $data = $data->where('primary_user_id', $primary_user_id);
        }
        if ($email) {
            $accounts = $accounts->where('email', 'like', '%'.$email.'%');
        }
        if ($phone) {
            $accounts = $accounts->whereIn('phone', $phone);
        }
        if ($company_id) {
            $accounts = $accounts->whereIn('company_id', $company_id);
        }
        if ($status_id) {
            $data = $data->where('status_id', $status_id);
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

        //dump($data);

        //order style - either 'desc' or 'asc'
        if (!$order_style) { $order_style = "desc"; }
        if (!$order_by) { $order_by = "id"; }

        //arrange by column
        $data = $data->orderBy($order_by, $order_style);

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
            if ($request->has('created_by')) {
                $data->appends('created_by', $request->get('created_by'));
            }
            if ($request->has('updated_by')) {
                $data->appends('updated_by', $request->get('updated_by'));
            }
            if ($request->has('company_branch_id')) {
                $data->appends('company_branch_id', $request->get('company_branch_id'));
            }
            if ($request->has('primary_user_id')) {
                $data->appends('primary_user_id', $request->get('primary_user_id'));
            }
            if ($request->has('email')) {
                $data->appends('email', $request->get('email'));
            }
            if ($request->has('phone')) {
                $data->appends('phone', $request->get('phone'));
            }
            if ($request->has('company_id')) {
                $data->appends('company_id', $request->get('company_id'));
            }
            //end query params
        }
        //dd(DB::getQueryLog());

		return $data;

	}

}