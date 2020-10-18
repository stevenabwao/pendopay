<?php

namespace App\Services\GlAccountHistory;

use App\Entities\GlAccountHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GlAccountHistoryIndex
{

	public function getData($request)
	{

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
        $data = new GlAccountHistory();

        //get params
        $report = $request->report;
        $id = $request->id;
        $payment_id = $request->payment_id;
        $event_id = $request->event_id;
        $account_search = $request->account_search;
        $gl_account_no = $request->gl_account_no;
        $dr_cr_ind = $request->dr_cr_ind;
        $channel_id = $request->channel_id;
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

        $data = $data->join('gl_accounts', 'gl_account_history.gl_account_no', '=', 'gl_accounts.gl_account_no');
        $data = $data->join('companies', 'gl_account_history.company_id', '=', 'companies.id');

        //filter results
        if ($id) {
            $data = $data->where('gl_account_history.id', $id);
        }
        if ($payment_id) {
            $data = $data->where('gl_account_history.payment_id', $payment_id);
        }
        if ($account_search) {
            $account_search_values = getSplitTerms($account_search); 
            $data = $data->where('gl_account_history.gl_account_no', "LIKE", '%' . $account_search . '%')
                         ->orWhere(function ($q) use ($account_search_values) {
                            foreach ($account_search_values as $value) {
                                $q->orWhere('gl_accounts.description', 'like', "%{$value}%");
                            }
                         });
        }
        if ($event_id) {
            $data = $data->where('gl_account_history.event_id', $event_id);
        }
        if ($gl_account_no) {
            $data = $data->where('gl_account_history.gl_account_no', $gl_account_no);
        }
        if ($dr_cr_ind) {
            $data = $data->where('gl_account_history.dr_cr_ind', $dr_cr_ind);
        }
        if ($channel_id) {
            $data = $data->where('gl_account_history.channel_id', $channel_id);
        }
        if (count($companies_num_array)) {
            $data = $data->whereIn('gl_account_history.company_id', $companies_num_array);
        }
        if ($status_id) {
            $data = $data->where('gl_account_history.status_id', $status_id);
        }
        if ($created_by) {
            $data = $data->where('gl_account_history.created_by', $created_by);
        }
        if ($updated_by) {
            $data = $data->where('gl_account_history.updated_by', $updated_by);
        }
        if ($start_date) {
            $data = $data->where('gl_account_history.created_at', '>=', $start_date);
        }
        if ($end_date) {
            $data = $data->where('gl_account_history.created_at', '<=', $end_date);
        }

        //select
        $data = $data->select('gl_account_history.id as id', 'gl_account_history.status_id as status_id', 
                              'gl_account_history.tran_desc as tran_desc', 'gl_account_history.tran_ref_txt as tran_ref_txt', 
                              'gl_accounts.description as description', 'gl_account_history.gl_account_no as gl_account_no', 
                              'gl_account_history.amount as amount', 'gl_account_history.created_at as created_at',
                              'companies.name as company_name');

        //order style - either 'desc' or 'asc'
        if (!$order_style) { $order_style = "desc"; }
        if (!$order_by) { $order_by = "gl_account_history.id"; }

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

        //dd($data);

        return $data;

	}

}