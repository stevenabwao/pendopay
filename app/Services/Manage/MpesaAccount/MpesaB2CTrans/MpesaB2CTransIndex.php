<?php

namespace App\Services\Manage\MpesaAccount\MpesaB2CTrans;

use App\Entities\SmsOutbox;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MpesaB2CTransIndex 
{

	public function getData($request)
	{
		
        //dd($request);

        $company_ids = getUserCompanyIds($request);
        //dd($company_ids);

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
        //$limit = $request->limit;
        $limit = $request->get('limit', config('app.pagination_limit'));

        $data = getCompanyMpesaTransactions($id, $page, $company_ids, $phone, $start_date, $end_date, 
                                 $order_by, $order_style, $limit, $report, $account_search);

        //dd($data);

		return $data;

	}

}