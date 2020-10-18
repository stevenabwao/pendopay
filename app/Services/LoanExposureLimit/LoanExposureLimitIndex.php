<?php

namespace App\Services\LoanExposureLimit;

use App\Entities\LoanExposureLimit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoanExposureLimitIndex 
{

	public function getLoanExposureLimits($request)
	{
		
        $companies_array = getUserCompanies($request);
        $companies_num_array = [];

        //get data
        foreach ($companies_array as $company) {
            //store in array
            $companies_num_array[] = $company->id;
        }

        //create data object
        $data = new LoanExposureLimit();

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
        
        if ($account_search) {
            $account_search_values = getSplitTerms($account_search); 
            //$data = $data->select('loan_exposure_limits.*', 'users.phone', 'deposit_accounts.account_name');
            $data = $data->join('deposit_accounts', 'loan_exposure_limits.company_user_id', '=', 'deposit_accounts.company_user_id');
            $data = $data->join('users', 'loan_exposure_limits.user_id', '=', 'users.id');
            $data = $data->join('company_user', 'loan_exposure_limits.company_user_id', '=', 'company_user.id');
            $data = $data->where('deposit_accounts.account_no', "LIKE", '%' . $account_search . '%')
                         ->orWhere(function ($q) use ($account_search_values, $account_search) {
                            $q->orWhere('users.phone', "LIKE", '%' . $account_search . '%');
                            foreach ($account_search_values as $value) {
                                $q->orWhere('deposit_accounts.account_name', 'like', "%{$value}%");
                            }
                         });
        }
        if ($id) { 
            $data = $data->where('loan_exposure_limits.id', $id); 
        }
        if (count($companies_num_array)) {
            $data = $data->whereIn('loan_exposure_limits.company_id', $companies_num_array);
        }
        if ($created_by) { 
            $data = $data->where('loan_exposure_limits.created_by', $created_by);
        }
        if ($updated_by) { 
            $data = $data->where('loan_exposure_limits.updated_by', $updated_by);
        }
        if ($start_date) { 
            $data = $data->where('loan_exposure_limits.created_at', '>=', $start_date); 
        }
        if ($end_date) { 
            $data = $data->where('loan_exposure_limits.created_at', '<=', $end_date); 
        }

        //order style - either 'desc' or 'asc'
        if (!$order_style) { $order_style = "desc"; }
        if (!$order_by) { $order_by = "loan_exposure_limits.updated_at"; }

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