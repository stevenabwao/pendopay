<?php

namespace App\Services\Channel;

use App\Entities\Channel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ChannelIndex 
{

	public function getChannels($request)
	{
		
		//create data object
        $data = new Channel();

        //get params
        $report = $request->report;
        $id = $request->id;
        $channel_cd = $request->channel_cd;
        $gl_dr_account = $request->gl_dr_account;
        $gl_cr_account = $request->gl_cr_account;
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
        if ($channel_cd) { 
            $data = $data->where('channel_cd', $channel_cd); 
        }
        if ($gl_dr_account) { 
            $data = $data->where('gl_dr_account', $gl_dr_account); 
        }
        if ($gl_cr_account) { 
            $data = $data->where('gl_cr_account', $gl_cr_account); 
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
        if (!$order_by) { $order_by = "id"; }

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
            if ($request->has('gl_dr_account')) {
                $data->appends('gl_dr_account', $request->get('gl_dr_account'));
            }
            if ($request->has('gl_cr_account')) {
                $data->appends('gl_cr_account', $request->get('gl_cr_account'));
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