<?php

namespace App\Services\Order;

use App\Entities\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderIndex
{

	public function getData($request)
	{

        $companies_array = getUserCompanies($request);
        $companies_num_array = [];

        //get data
        foreach ($companies_array as $company) {
            //store in array
            $companies_num_array[] = $company->id;
        }

        //create data object
        $data = new Order();

        //get params
        $report = $request->report;
        $id = $request->id;
        $account_search = $request->account_search;
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
            $data = $data->where('orders.id', $id);
        }
        if (count($companies_num_array)) {
            $data = $data->whereIn('orders.company_id', $companies_num_array);
        }
        if ($account_search) {
            $account_search_values = getSplitTerms($account_search);
            $data = $data->select('orders.*');
            $data = $data->join('deposit_accounts', 'orders.deposit_account_no', '=', 'deposit_accounts.account_no');
            $data = $data->join('users', 'orders.user_id', '=', 'users.id');
            $data = $data->where('users.phone', "LIKE", '%' . $account_search . '%')
                         ->orWhere(function ($q) use ($account_search_values) {
                            foreach ($account_search_values as $value) {
                                $q->orWhere('users.account_name', 'like', "%{$value}%");
                            }
                         });
        }
        if ($status_id) {
            $data = $data->where('orders.status_id', $status_id);
        }
        if ($created_by) {
            $data = $data->where('orders.created_by', $created_by);
        }
        if ($updated_by) {
            $data = $data->where('orders.updated_by', $updated_by);
        }
        if ($start_date) {
            $data = $data->where('orders.created_at', '>=', $start_date);
        }
        if ($end_date) {
            $data = $data->where('orders.created_at', '<=', $end_date);
        }

        //order style - either 'desc' or 'asc'
        if (!$order_style) { $order_style = "desc"; }
        if (!$order_by) { $order_by = "orders.id"; }

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
            if ($request->has('company_id')) {
                $data->appends('company_id', $request->get('company_id'));
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
            //end query params
        }

		return $data;

	}

}
