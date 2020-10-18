<?php

namespace App\Services\Sms;

use App\Entities\SmsOutbox;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SmsOutboxIndex 
{

	public function getData($request)
	{
		
        //dd($request);
        $company_ids = [];
        $company_ids[] = 53;

        //$company_ids = getUserCompanyIds($request);

        //get params
        $report = $request->report;
        $id = $request->id;
        $page = $request->page;
        $phone = $request->phone;
        $account_search = $request->account_search;
        $status_name = $request->status_name;
        $order_by = $request->order_by;
        $order_style = $request->order_style;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $limit = $request->limit;

        $data = getRemoteSmsData($id, $page, $company_ids, $phone, $start_date, $end_date, 
                                 $order_by, $order_style, $limit, $report, $account_search);

        //dd($data);

		return $data;

	}

}