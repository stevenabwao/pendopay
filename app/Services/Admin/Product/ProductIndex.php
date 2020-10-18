<?php

namespace App\Services\Admin\Product;

use App\Entities\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductIndex 
{

	public function getData($request)
	{

        // DB::enableQueryLog();

        //get data
        $data = new Product();
        //$data = $data->with('users')
        //        ->with('images');

        //get params
        $report = $request->report;
        $id = $request->id;
        $account_search = $request->account_search;
        $user_id = $request->user_id;
        $categories = $request->categories;
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
        /* if ($user_id) { 
            $data = $data
                            ->join('company_user', 'companies.id','=','company_user.categories')
                            ->join('users','users.id','=','company_user.user_id')
                            ->where('users.id', $user_id);
        } */
        if ($categories) { 
            $data = $data->where('product_category_id', $categories); 
        }
        if ($account_search) {
            $account_search_values = getSplitTerms($account_search); 
            // $data = $data->select('companies.*');
            $data = $data->where('name', "LIKE", '%' . $account_search . '%');
                         /* ->orWhere(function ($q) use ($account_search_values) {
                            foreach ($account_search_values as $value) {
                                $q->orWhere('name', 'like', "%{$value}%");
                            }
                         }); */
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
        if (!$order_style) { $order_style = "asc"; }
        if (!$order_by) { $order_by = "name"; }

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

        // dd(DB::getQueryLog());

		return $data;

	}

}