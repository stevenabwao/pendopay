<?php

namespace App\Services\LoanProductSetting;

use App\Entities\LoanProductSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoanProductSettingIndex 
{

	public function getLoanProductSettings($request)
	{
        
        $companies_num_array = [];

        if ($request->company_id) {

            $companies_num_array[] = $request->company_id;

        } else {

            $companies_array = getUserCompanies($request);

            // get data
            foreach ($companies_array as $company) {
                // store in array
                $companies_num_array[] = $company->id;
            }
        }

        // create data object
        $data = new LoanApplication();

        // get params
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
            $data = $data->where('loan_applications.id', $id); 
        }
        if ($phone) { 
            $data = $data->where('loan_applications.phone', $phone); 
        }
        if (count($companies_num_array)) {
            $data = $data->whereIn('loan_applications.company_id', $companies_num_array);
        }
        
        if ($account_search || $phone) {

            $account_search_values = getSplitTerms($account_search); 
            $data = $data->select('loan_applications.*', 'deposit_accounts.account_name');
            $data = $data->join('users', 'loan_applications.user_id', '=', 'users.id');

            // if phone is supplied in search
            if ($phone) {

                $data = $data->where('users.phone', "LIKE", '%' . $phone . '%');

            } else {

                $data = $data->join('deposit_accounts', 'loan_applications.deposit_account_no', '=', 'deposit_accounts.account_no');
                $data = $data->where('deposit_account_no', "LIKE", '%' . $account_search . '%')
                         ->orWhere('users.phone', "LIKE", '%' . $account_search . '%')
                         ->orWhere(function ($q) use ($account_search_values) {
                             foreach ($account_search_values as $value) {
                                 $q->orWhere('deposit_accounts.account_name', 'like', "%{$value}%");
                             }
                         });

            }

        }
        if ($status_id) { 
            $data = $data->where('loan_applications.status_id', $status_id);
        }
        if ($created_by) { 
            $data = $data->where('loan_applications.created_by', $created_by);
        }
        if ($updated_by) { 
            $data = $data->where('loan_applications.updated_by', $updated_by);
        }
        if ($start_date) { 
            $data = $data->where('loan_applications.created_at', '>=', $start_date); 
        }
        if ($end_date) { 
            $data = $data->where('loan_applications.created_at', '<=', $end_date); 
        }

        //order style - either 'desc' or 'asc'
        if (!$order_style) { $order_style = "desc"; }
        if (!$order_by) { $order_by = "loan_applications.id"; }

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