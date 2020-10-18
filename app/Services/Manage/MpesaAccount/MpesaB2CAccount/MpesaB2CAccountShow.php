<?php

namespace App\Services\Manage\MpesaAccount\MpesaB2CAccount;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MpesaB2CAccountShow 
{

	public function getData($id)
	{
		
        $company_ids = getUserCompanyIds();

        $data = showSingleMpesaShortcodeData($id, $company_ids);

        //dd($data);

		return $data;

	}

}