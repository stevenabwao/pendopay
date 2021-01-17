<?php

namespace App\Services\Payment;

use App\Entities\Payment;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentIndex
{

	public function getData($request)
	{

        // dd($request);

        $data = new Payment();
        /* $paybills = "";
        $paybills_num_array = []; */

        // get logged in user
        // $user = auth()->user();
        // dd($user);
        /* $user_company_ids = "";
        if (!isSuperadmin()) {
            $user_company_ids = getUserCompanyids();
            // dd($user_company_ids);
        } */

        //get params
        $report = $request->report;
        $id = $request->id;
        $companies = $request->companies;
        $account_search = $request->account_search;
        $status_id = $request->status_id;
        $processed = $request->processed;
        $created_by = $request->created_by;
        $updated_by = $request->updated_by;
        $order_by = $request->order_by;
        $order_style = $request->order_style;

        $start_date = $request->start_date;
        if ($start_date) {
            $start_date = Carbon::parse($request->start_date);
            $start_date = $start_date->startOfDay();
            $start_date_utc = formatUtcDate($start_date);
        }
        $end_date = $request->end_date;
        if ($end_date) {
            $end_date = Carbon::parse($request->end_date);
            $end_date = $end_date->endOfDay();
            $end_date_utc = formatUtcDate($end_date);
        }

        //filter results
        /* if (!isSuperadmin()) {
            $data = $data->whereIn('company_id', $user_company_ids);
        } */
        if ($id) {
            $data = $data->where('id', $id);
        }
        /* if ($companies) {
            $data = $data->whereIn('company_id', $companies);
        } */
        /* if ($paybills) {
            $data = $data->whereIn('paybill_number', $paybills_num_array);
        } */
        if ($account_search) {
            $account_search_values = getSplitTerms($account_search);
            $data = $data->where('full_name', "LIKE", '%' . $account_search . '%')
                            ->orWhere('account_name', "LIKE", '%' . $account_search . '%')
                            ->orWhere('account_no', "LIKE", '%' . $account_search . '%')
                            ->orWhere('trans_id', "LIKE", '%' . $account_search . '%')
                            ->orWhere('phone', $account_search);
        }
        if ($processed) {
            $processed_value = $processed;
            if ($processed == '99') { $processed_value = 0; }
            $data = $data->where('processed', $processed_value);
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
            $data = $data->where('created_at', '>=', $start_date_utc);
        }
        if ($end_date) {
            $data = $data->where('created_at', '<=', $end_date_utc);
        }

        //order style - either 'desc' or 'asc'
        if (!$order_style) { $order_style = "desc"; }
        if (!$order_by) { $order_by = "id"; }

        //arrange by column
        $data = $data->orderBy($order_by, $order_style);
        // dd($data);

        //are we in report mode?
        //if not, set url appended params
        if (!$report) {

            $limit = $request->get('limit', config('app.pagination_limit'));
            $data = $data->paginate($limit);

            //add query params
            if ($request->has('order_by')) {
                $data->appends('order_by', $request->get('order_by'));
            }
            if ($companies) {
                $data->appends('companies', $companies);
            }
            if ($processed) {
                $data->appends('processed', $processed);
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

        //dd($data);

        return $data;


	}

}
