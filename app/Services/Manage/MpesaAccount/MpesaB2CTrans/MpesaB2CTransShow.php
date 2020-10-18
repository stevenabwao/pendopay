<?php

namespace App\Services\Manage\MpesaAccount\MpesaB2CTrans;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MpesaB2CTransShow 
{

	public function getData($id)
	{
		
        $company_ids = getUserCompanyIds();

        $data = showSingleMpesaTransData($id, $company_ids);

        //dd($data);

		return $data;

	}

}