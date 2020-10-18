<?php

namespace App\Services\SupervisorClientAssign;

use App\Entities\SupervisorClientAssignDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SupervisorClientAssignDetailIndex
{

	public function getData($request)
	{
        
        DB::enableQueryLog(); 

        $status_active = config('constants.status.active');
        $status_inactive = config('constants.status.inactive');

        //get user companies
        $companies_num_array = [];
        $companies = $request->companies;
        $account_search = $request->account_search;

        if ($companies) {
            $companies_num_array = explode(",", $companies);
        }

        //create data object
        $data = new SupervisorClientAssignDetail();
        $data = $data->select('supervisor_client_assign_details.*');
        $data = $data->join('company_user', 'supervisor_client_assign_details.company_user_id', '=', 'company_user.id');
        $data = $data->join('users', 'company_user.user_id', '=', 'users.id');

        if ($account_search) {
            $account_search_values = getSplitTerms($account_search); 
            $data = $data->where('users.phone', "LIKE", '%' . $account_search . '%')
                         ->orWhere(function ($q) use ($account_search_values) {
                            foreach ($account_search_values as $value) {
                                $q->orWhere('users.first_name', 'like', "%{$value}%");
                                $q->orWhere('users.last_name', 'like', "%{$value}%");
                            }
                         });
        }

        //get params
        $report = $request->report;
        $id = $request->id;
        $company_supervisor_id = $request->company_supervisor_id;
        
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
            $data = $data->where('supervisor_client_assign_details.id', $id); 
        }
        if ($company_supervisor_id) { 
            $data = $data->where('supervisor_client_assign_details.company_supervisor_id', $company_supervisor_id); 
        }
        if ($status_id == $status_active) { 
            $data = $data->where('company_user.registration_paid', "1");
        } 
        if ($status_id == $status_inactive) { 
            $data = $data->where('company_user.registration_paid', "0");
        } 
        if (count($companies_num_array)) {
            $data = $data->whereIn('supervisor_client_assign_details.company_id', $companies_num_array);
        }
        if ($created_by) { 
            $data = $data->where('supervisor_client_assign_details.created_by', $created_by);
        }
        if ($updated_by) { 
            $data = $data->where('supervisor_client_assign_details.updated_by', $updated_by);
        }
        if ($start_date) { 
            $data = $data->where('supervisor_client_assign_details.created_at', '>=', $start_date); 
        }
        if ($end_date) { 
            $data = $data->where('supervisor_client_assign_details.created_at', '<=', $end_date); 
        }

        //order style - either 'desc' or 'asc'
        if (!$order_style) { $order_style = "asc"; }
        if (!$order_by) { $order_by = "users.first_name"; }

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

        //$queries = \DB::getQueryLog();
        //return dd($queries);

		return $data;

	}

}
