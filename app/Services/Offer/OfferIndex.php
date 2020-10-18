<?php

namespace App\Services\Offer;

use App\Entities\Offer;
use Carbon\Carbon;

class OfferIndex
{

	public function getData($request)
	{

        // DB::enableQueryLog();
        // dd($request->all());

        //create data object
        $data = new Offer();

        //get params
        $report = $request->report;
        $id = $request->id;
        $companies = getUserCompanyIds($request);
        $company_id = $request->company_id;
        $account_search = $request->account_search;
        $offer_type = $request->offer_type;
        $offer_frequency = $request->offer_frequency;
        $offer_expiry_method = $request->offer_expiry_method;
        $min_age = $request->min_age;
        $max_age = $request->max_age;
        $offer_day = $request->offer_day;
        $status_id = $request->status_id;
        $created_by = $request->created_by;
        $updated_by = $request->updated_by;
        $order_by = $request->order_by;
        $order_style = $request->order_style;
        $expiry_date = $request->expiry_date;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $cat_id = $request->cat_id;
        $count = $request->count;
        $num_sales = $request->num_sales;
        $max_sales = $request->max_sales;

        if ($expiry_date) {
            $expiry_date = Carbon::parse($request->expiry_date);
            $expiry_date = $expiry_date->endOfDay();
        }
        if ($start_date) {
            $start_date = Carbon::parse($request->start_date);
            $start_date = $start_date->startOfDay();
        }
        if ($end_date) {
            $end_date = Carbon::parse($request->end_date);
            $end_date = $end_date->endOfDay();
        }

        // get data
        $data = $data->select('offers.*');
        $data = $data->join('companies', 'offers.company_id', '=', 'companies.id');

        //filter results
        if ($id) {
            $data = $data->where('offers.id', $id);
        }
        if ($offer_type) {
            $data = $data->where('offers.offer_type', $offer_type);
        }
        if ($offer_frequency) {
            $data = $data->where('offers.offer_frequency', $offer_frequency);
        }
        if ($offer_expiry_method) {
            $data = $data->where('offers.offer_expiry_method', $offer_expiry_method);
        }
        if ($min_age) {
            $data = $data->where('offers.min_age', $min_age);
        }
        if ($max_age) {
            $data = $data->where('offers.max_age', $max_age);
        }
        if ($min_age) {
            $data = $data->where('offers.min_age', $min_age);
        }
        if ($offer_day) {
            $data = $data->where('offers.offer_day', $offer_day);
        }
        if ($company_id) {
            $data = $data->where('offers.company_id', $company_id);
        }
        if ($companies) {
            $data = $data->whereIn('offers.company_id', $companies);
        }
        if ($max_sales) {
            $data = $data->where('offers.max_sales', $max_sales);
        }
        if ($num_sales) {
            $data = $data->where('offers.num_sales', $num_sales);
        }
        if ($cat_id) {
            // $data = $data->where('offers.cat_id', $cat_id);
            $data = $data->where('companies.category_id', $cat_id);
        }
        if ($account_search) {
            $account_search_values = getSplitTerms($account_search);
            $data = $data->where('offers.name', "LIKE", '%' . $account_search . '%')
                         ->orWhere('offers.description', "LIKE", '%' . $account_search . '%')
                         ->orWhere(function ($q) use ($account_search_values) {
                            foreach ($account_search_values as $value) {
                                $q->orWhere('offers.name', 'like', "%{$value}%");
                            }
                         });
        }
        if ($status_id) {
            $data = $data->where('offers.status_id', $status_id);
        }
        if ($created_by) {
            $data = $data->where('offers.created_by', $created_by);
        }
        if ($updated_by) {
            $data = $data->where('offers.updated_by', $updated_by);
        }
        if ($start_date) {
            $data = $data->where('offers.created_at', '>=', $start_date);
        }
        if ($end_date) {
            $data = $data->where('offers.created_at', '<=', $end_date);
        }

        //order style - either 'desc' or 'asc'
        if (!$order_style) { $order_style = "desc"; }
        if (!$order_by) { $order_by = "offers.id"; }

        //arrange by column
        $data = $data->orderBy($order_by, $order_style);

        // filter?
        if ($count && $report) {
            $data = $data->limit($count);
        }

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

        // $data = $data->get();

        // dd("data === ", $data);

        // dd("Here ::: ", DB::getQueryLog());

		return $data;

	}

}
