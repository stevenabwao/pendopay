<?php

namespace App\Services\Shares;

use App\Entities\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SharesIndex
{

	public function getData($request)
	{

		//get logged in user
        $user = auth()->user();

        //get data
        if ($user->hasRole('superadministrator')){

            //get data
            $data = new Account();

        } else if ($user->hasRole('administrator')){

            //get user company
            $user_company_id = $user->company->id;

            //get data
            $data = Account::where('company_id', $user_company_id);

        } else {

            //user is not authorized/ logged in, abort immediately
            abort(503);

        }

        //get params
        $report = $request->report;
        $id = $request->id;
        $account_no = $request->account_no;
        $company_id = $request->company_id;
        $product_id = $request->product_id;
        $payment_method_id = $request->payment_method_id;
        $user_id = $data->user_id;
        $currency_id = $data->currency_id;
        $group_id = $data->group_id;
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
        if ($account_no) {
            $data = $data->where('account_no', $account_no);
        }
        if ($company_id) {
            $data = $data->where('company_id', $company_id);
        }
        if ($product_id) {
            $data = $data->where('product_id', $product_id);
        }
        if ($group_id) {
            $data = $data->whereIn('group_id', $group_id);
        }
        if ($user_id) {
            $data = $data->whereIn('user_id', $user_id);
        }
        if ($currency_id) {
            $data = $data->where('currency_id', $currency_id);
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

		return $data;

	}

}