<?php

namespace App\Services\TransactionRequest;

use App\Entities\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionRequestIndex
{

	public function getData($request)
	{

        DB::enableQueryLog();

        //create data object
        $data = new Transaction();

        //get params
        $report = $request->report;
        $id = $request->id;
        $seller_user_id = $request->seller_user_id;
        $buyer_user_id = $request->buyer_user_id;
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
        if ($seller_user_id) {
            $data = $data->where('seller_user_id', $seller_user_id);
        }
        if ($buyer_user_id) {
            $data = $data->where('buyer_user_id', $buyer_user_id);
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

        // get records where user is seller or buyer
        $logged_user_id = getLoggedUser()->id;
        $data = $data->where(function($q) use ($logged_user_id){
            $q->orWhere('seller_user_id', '=', $logged_user_id);
            $q->orWhere('buyer_user_id', '=', $logged_user_id);
        });

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

            // limit number of pagination links onn each side of current page
            /* $data = $data->onEachSide(2); */

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

        // $queries = \DB::getQueryLog();
        //return dd($queries);

		return $data;

	}

}
