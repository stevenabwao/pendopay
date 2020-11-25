<?php

namespace App\Services\MyPayment;

use App\Entities\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MyPaymentIndex
{

	public function getData($request)
	{

        DB::enableQueryLog();

        //create data object
        $data = new Payment();

        //get params
        $report = $request->report;
        $id = $request->id;
        $payment_method_id = $request->payment_method_id;
        $phone = $request->phone;
        $account_no = $request->account_no;
        $paybill_number = $request->paybill_number;
        $trans_id = $request->trans_id;
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
        if ($payment_method_id) {
            $data = $data->where('payment_method_id', $payment_method_id);
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
        if ($phone) {
            $data = $data->where('phone', $phone);
        }
        if ($account_no) {
            $data = $data->where('account_no', $account_no);
        }
        if ($paybill_number) {
            $data = $data->where('paybill_number', $paybill_number);
        }
        if ($trans_id) {
            $data = $data->where('trans_id', $trans_id);
        }
        if ($start_date) {
            $data = $data->where('created_at', '>=', $start_date);
        }
        if ($end_date) {
            $data = $data->where('created_at', '<=', $end_date);
        }

        // get records where user is seller or buyer
        $logged_user = getLoggedUser();
        $logged_user_phone = $logged_user->phone;
        $data = $data->where('phone', '=', $logged_user_phone);

        //order style - either 'desc' or 'asc'
        if (!$order_style) { $order_style = "desc"; }
        if (!$order_by) { $order_by = "id"; }

        //arrange by column
        $data = $data->orderBy($order_by, $order_style);

        //are we in report mode?
        //if not, set url appended params
        if (!$report) {

            $limit = $request->get('limit', getAppPaginationShort());
            $data = $data->paginate($limit);

            //add query params
            if ($request->has('order_by')) {
                $data->appends('order_by', $request->get('order_by'));
            }
            if ($request->has('order_style')) {
                $data->appends('order_style', $request->get('order_style'));
            }
            if ($request->has('payment_method_id')) {
                $data->appends('payment_method_id', $request->get('payment_method_id'));
            }
            if ($request->has('trans_id')) {
                $data->appends('trans_id', $request->get('trans_id'));
            }
            if ($request->has('account_no')) {
                $data->appends('account_no', $request->get('account_no'));
            }
            if ($request->has('phone')) {
                $data->appends('phone', $request->get('phone'));
            }
            if ($request->has('paybill_number')) {
                $data->appends('paybill_number', $request->get('paybill_number'));
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

        // $queries = \DB::getQueryLog();
        //return dd($queries);

		return $data;

	}

}
