<?php

namespace App\Services\LoanAccountSummary;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoanAccountSummaryIndex
{

	public function getData($request)
	{

        DB::enableQueryLog(); 

        $companies_array = getUserCompanies($request);

        //get data
        foreach ($companies_array as $company) {
            //store in array
            $companies_num_array[] = $company->id;
        }

        return $data;

	}

}