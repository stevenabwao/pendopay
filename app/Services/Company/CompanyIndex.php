<?php

namespace App\Services\Company;

use App\Entities\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CompanyIndex
{

	public function getData($request)
	{

        // dd("request == ", $request);
        // DB::enableQueryLog();

        //get data
        $data = new Company();

        //get params
        $report = $request->report;
        $id = $request->id;
        $count = $request->count;
        $cat_id = $request->cat_id;
        $paybill_no = $request->paybill_no;
        $phone = $request->phone;
        $personal_phone = $request->personal_phone;
        $town = $request->town;
        $email = $request->email;
        $personal_email = $request->personal_email;
        $county_id = $request->county_id;
        $random = $request->random;
        $account_search = $request->account_search;
        $company_id = $request->company_id;
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
        if ($company_id) {
            $data = $data->where('id', $company_id);
        }
        if ($account_search) {
            $account_search_values = getSplitTerms($account_search);
            $data = $data->select('companies.*');
            $data = $data->where('name', "LIKE", '%' . $account_search . '%')
                         ->orWhere(function ($q) use ($account_search_values) {
                            foreach ($account_search_values as $value) {
                                $q->orWhere('name', 'like', "%{$value}%");
                            }
                         });
        }
        if ($cat_id) {
            $data = $data->where('category_id', $cat_id);
        }
        if ($paybill_no) {
            $data = $data->where('paybill_no', $paybill_no);
        }
        if ($phone) {
            $data = $data->where('phone', $phone);
        }
        if ($personal_phone) {
            $data = $data->where('personal_phone', $personal_phone);
        }
        if ($town) {
            $data = $data->where('town', $town);
        }
        if ($email) {
            $data = $data->where('email', $email);
        }
        if ($personal_email) {
            $data = $data->where('personal_email', $personal_email);
        }
        if ($county_id) {
            $data = $data->where('county_id', $county_id);
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
        if (!$order_by) { $order_by = "companies.id"; }

        //arrange by column
        $data = $data->orderBy($order_by, $order_style);

        if ($random) {
            $data = $data->inRandomOrder();
        }

        // filter?
        if ($count && $report) {
            $data = $data->limit($count);
        }
        // dd($random, DB::getQueryLog());

        //are we in report mode?
        //if not, set url appended params
        if (!$report) {

            $limit = $request->get('limit', config('app.pagination_limit'));
            $data = $data->paginate($limit);

            //add query params
            if ($request->has('category_id')) {
                $data->appends('category_id', $request->get('category_id'));
            }
            if ($request->has('limit')) {
                $data->appends('limit', $request->get('limit'));
            }
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

        // dd($data);

		return $data;

	}

}
