<?php

namespace App\Services\Account;

use App\Entities\Account;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AccountIndex
{

	public function getAccounts($request)
	{

        //dd($request);
        DB::enableQueryLog();

        $companies_array = getUserCompanies($request);
        $companies_num_array = [];

        //get data
        foreach ($companies_array as $company) {
            //store in array
            $companies_num_array[] = $company->id;
        }
        //$companies_array = explode(',', $companies_num_array);
        //dd($companies_num_array);

        //create data object
        $data = new Account();

        //get params
        $report = $request->report;
        $id = $request->id;
        $account_search = $request->account_search;
        //$company_id = $request->company_id;
        $product_id = $request->product_id;
        $account_name = $request->account_name;
        $company_user_id = $request->company_user_id;
        $user_id = $request->user_id;
        $currency_id = $request->currency_id;
        $group_id = $request->group_id;
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
        if ($account_search) {
            $account_search_values = getSplitTerms($account_search); 
            $data = $data->where('account_no', "LIKE", '%' . $account_search . '%')
                         ->orWhere(function ($q) use ($account_search_values) {
                            foreach ($account_search_values as $value) {
                                $q->orWhere('account_name', 'like', "%{$value}%");
                            }
                         });
        }
        if (count($companies_num_array)) {
            $data = $data->whereIn('company_id', $companies_num_array);
        }
        if ($product_id) {
            $data = $data->where('product_id', $product_id);
        }
        if ($account_name) {
            $accounts = $accounts->where('account_name', 'like', '%'.$account_name.'%');
        }
        if ($group_id) {
            $accounts = $accounts->whereIn('group_id', $group_id);
        }
        if ($company_user_id) {
            $accounts = $accounts->whereIn('company_user_id', $company_user_id);
        }
        if ($user_id) {
            $accounts = $accounts->whereIn('user_id', $user_id);
        }
        if ($currency_id) {
            $accounts = $accounts->where('currency_id', $currency_id);
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
            //end query params
        }
        //dd('data - ' . $data);
        //dd(DB::getQueryLog());

		return $data;

	}

}