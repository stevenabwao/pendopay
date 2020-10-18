<?php

namespace App\Services\DepositAccountHistory;

use App\Entities\DepositAccountHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DepositAccountHistoryIndex
{

	public function getData($request)
	{

        //DB::enableQueryLog(); 

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
        $data = new DepositAccountHistory();
        //$data = DB::table('deposit_account_history');

        //get params
        $report = $request->report;
        $id = $request->id;
        $account_no = $request->account_no;
        $parent_id = $request->parent_id;
        $charge_id = $request->charge_id;
        $account_search = $request->account_search;
        $user_id = $request->user_id;
        //$companies = $request->companies;
        $company_user_id = $request->company_user_id;
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

        //if ($account_search) {
            // $data = $data->join('deposit_accounts', 'deposit_account_history.account_no', '=', 'deposit_accounts.account_no');
            // $data = $data->join('accounts', 'accounts.account_no', '=', 'deposit_accounts.ref_account_no');
            // $data = $data->join('companies', 'accounts.company_id', '=', 'companies.id');
            //$data = $data->where('deposit_account_history.account_no', '=', 'deposit_accounts.account_no');
        //}

        //filter results
        if ($id) {
            $data = $data->where('deposit_account_history.id', $id);
        }
        if ($account_no) {
            $data = $data->where('deposit_account_history.account_no', $account_no);
        }
        if ($parent_id) {
            $data = $data->where('deposit_account_history.parent_id', $parent_id);
        }
        if ($account_search) {
            $account_search_values = getSplitTerms($account_search); 
            $data = $data->select('deposit_account_history.*');
            $data = $data->join('deposit_account_summary', 'deposit_account_history.parent_id', '=', 'deposit_account_summary.id');
            $data = $data->join('deposit_accounts', 'deposit_account_history.account_no', '=', 'deposit_accounts.account_no');
            $data = $data->where('deposit_account_history.account_no', "LIKE", '%' . $account_search . '%')
                         ->orWhere('deposit_account_summary.phone', "LIKE", '%' . $account_search . '%')
                         ->orWhere(function ($q) use ($account_search_values) {
                            foreach ($account_search_values as $value) {
                                $q->orWhere('deposit_accounts.account_name', 'LIKE', "%{$value}%");
                            }
                         });
        }
        if (count($companies_num_array)) {
            $data = $data->whereIn('deposit_account_history.company_id', $companies_num_array);
        }
        if ($user_id) {
            $data = $data->where('deposit_account_history.user_id', $user_id);
        }
        if ($company_user_id) {
            $data = $data->where('deposit_account_history.company_user_id', $company_user_id);
        }
        if ($status_id) {
            $data = $data->where('deposit_account_history.status_id', $status_id);
        }
        if ($created_by) {
            $data = $data->where('deposit_account_history.created_by', $created_by);
        }
        if ($updated_by) {
            $data = $data->where('deposit_account_history.updated_by', $updated_by);
        }
        if ($start_date) {
            $data = $data->where('deposit_account_history.created_at', '>=', $start_date);
        }
        if ($end_date) {
            $data = $data->where('deposit_account_history.created_at', '<=', $end_date);
        }

        //select
        // $data = $data->select('deposit_account_history.id as id', 'deposit_account_history.status_id as status_id', 
        //                       'accounts.account_name as account_name', 'deposit_accounts.account_no as account_no', 
        //                       'deposit_account_history.amount as amount', 'deposit_account_history.created_at as created_at',
        //                       'companies.name as company_name');

        //order style - either 'desc' or 'asc'
        if (!$order_style) { $order_style = "desc"; }
        if (!$order_by) { $order_by = "deposit_account_history.id"; }

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

        //dd(DB::getQueryLog());
        //$data = $data->get();

        //dd($data);

        return $data;

	}

}