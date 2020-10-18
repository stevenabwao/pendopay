<?php

namespace App\Services\Sms;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SmsOutboxShow 
{

	public function getData($id)
	{
		
        $company_ids = getUserCompanyIds();

        $data = showRemoteSmsData($id, $company_ids);

        //dd($data);

		return $data;

	}

}