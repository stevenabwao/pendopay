<?php

namespace App\Services\SiteContent;

use App\Entities\SiteContent;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SiteContentIndex 
{

	public function getData($request)
	{

        dd($request);

        DB::enableQueryLog();

        //get data
        $data = new SiteContent();
        $data = $data->join("categories", "categories.id", "=", "site_content.category_id");

        //get params
        $report = $request->report;
        $id = $request->id;
        $status = $request->status;
        $type = $request->type;
        $category = $request->category;
        $limit = $request->limit;

        $order_by = $request->order_by;
        $order_style = $request->order_style;

        $start_date = $request->start_date;
        if (!$type) { 
            $type = "normal"; 
        }
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
            $data = $data->where('site_content.id', $id); 
        }
        if ($status) { 
            $data = $data->where('site_content.status_id', $status);
        }
        if ($category) { 
            $data = $data->where('site_content.category_id', $category);
        }                   
        if ($start_date) { 
            $data = $data->where('created_at', '>=', $start_date); 
        }
        if ($end_date) { 
            $data = $data->where('created_at', '<=', $end_date); 
        }

        $data = $data->leftJoin('images', function($join) use ($type) {
            $join->on('images.category_id', 'site_content.category_id');
            $join->where('images.imagetable_type', $type);
            $join->where('images.status_id', "1");
            $join->on('images.imagetable_id', 'site_content.id');
        })
        ->select(
                'site_content.*', 
                'categories.code', 
                'categories.cat_permalink', 
                'images.full_img', 
                'images.thumb_img' 
        );

        //order style - either 'desc' or 'asc'
        if (!$order_style) { $order_style = "desc"; }
        if (!$order_by) { $order_by = "site_content.id"; }

        //arrange by column
        $data = $data->orderBy($order_by, $order_style);

        

        //are we in report mode?
        //if not, set url appended params 
        if (!$report) {

            if (!$limit){
                $limit = $request->get('limit', config('app.pagination_limit'));
            }

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

        //print_r(DB::getQueryLog());

	    //dd('stop here');

		return $data;

	}

}