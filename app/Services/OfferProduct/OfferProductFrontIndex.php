<?php

namespace App\Services\OfferProduct;

use App\Entities\OfferProduct;
use Carbon\Carbon;

class OfferProductFrontIndex
{

	public function getData($request)
	{

        // DB::enableQueryLog();

        //create data object
        $data = new OfferProduct();

        //get params
        $report = $request->report;
        $id = $request->id;
        $company_id = $request->company_id;
        $account_search = $request->account_search;
        $offer_id = $request->offer_id;
        $company_product_id = $request->company_product_id;
        $status_id = $request->status_id;
        $created_by = $request->created_by;
        $updated_by = $request->updated_by;
        $order_by = $request->order_by;
        $order_style = $request->order_style;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $count = $request->count;
        $random = $request->random;

        if ($start_date) {
            $start_date = Carbon::parse($request->start_date);
            $start_date = $start_date->startOfDay();
        }
        if ($end_date) {
            $end_date = Carbon::parse($request->end_date);
            $end_date = $end_date->endOfDay();
        }

        // get data
        $data = $data->select('offer_products.*');
        $data = $data->join('companies', 'offer_products.company_id', '=', 'companies.id');

        // check if we are searching
        if ($account_search) {
            $data = $data->join('company_products', 'offer_products.company_product_id', '=', 'company_products.id');
            $data = $data->join('products', 'company_products.product_id', '=', 'products.id');
            $data = $data->join('offers', 'offer_products.offer_id', '=', 'offers.id');
            $account_search_values = getSplitTerms($account_search);
            $data = $data->where('products.name', "LIKE", '%' . $account_search . '%')
                         ->orWhere('companies.name', "LIKE", '%' . $account_search . '%')
                         ->orWhere('offers.name', "LIKE", '%' . $account_search . '%')
                         ->orWhere(function ($q) use ($account_search_values) {
                            foreach ($account_search_values as $value) {
                                $q->orWhere('products.name', 'like', "%{$value}%");
                                $q->orWhere('companies.name', 'like', "%{$value}%");
                                $q->orWhere('offers.name', 'like', "%{$value}%");
                            }
                         });
        }

        //filter results
        if ($id) {
            $data = $data->where('offer_products.id', $id);
        }
        if ($offer_id) {
            $data = $data->where('offer_products.offer_id', $offer_id);
        }
        if ($company_product_id) {
            $data = $data->where('offer_products.company_product_id', $company_product_id);
        }
        if ($company_id) {
            $data = $data->where('offer_products.company_id', $company_id);
        }
        if ($status_id) {
            $data = $data->where('offer_products.status_id', $status_id);
        }
        if ($created_by) {
            $data = $data->where('offer_products.created_by', $created_by);
        }
        if ($updated_by) {
            $data = $data->where('offer_products.updated_by', $updated_by);
        }
        if ($start_date) {
            $data = $data->where('offer_products.created_at', '>=', $start_date);
        }
        if ($end_date) {
            $data = $data->where('offer_products.created_at', '<=', $end_date);
        }

        //order style - either 'desc' or 'asc'
        if (!$order_style) { $order_style = "desc"; }
        if (!$order_by) { $order_by = "offer_products.id"; }

        //arrange by column
        $data = $data->orderBy($order_by, $order_style);

        // random?
        if ($random==1) {
            // $data = $data->random($count);
            $data = $data->inRandomOrder();
        }

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
            if ($request->has('limit')) {
                $data->appends('limit', $request->get('limit'));
            }
            if ($request->has('offer_id')) {
                $data->appends('offer_id', $request->get('offer_id'));
            }
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

        // dd("Here ::: ", DB::getQueryLog());

		return $data;

	}

}
