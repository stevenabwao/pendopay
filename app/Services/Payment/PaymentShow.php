<?php

namespace App\Services\Payment;

use App\Entities\Payment;
use App\Entities\PaymentDeposit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentShow
{

	public function getData($id)
	{

        $user = auth()->user();
        
        //get details
        $data = Payment::where('id', $id);
        if ($user->hasRole('administrator')) {
            $company_id = $user->company->id;
            $data = $data->where('company_id', $company_id);
        }
        $data = $data->first();

        return $data;

    }
    
    public function getDepositRecord($id)
	{

        $user = auth()->user();
        
        //get details
        $data = PaymentDeposit::where('payment_id', $id);
        $data = $data->first();

        return $data;

	}

}