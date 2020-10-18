<?php

namespace App\Services\Payment;

use App\Entities\Payment;
use App\Events\PaymentUpdated;
use Illuminate\Support\Facades\DB;

class PaymentUpdate
{

	public function updateItem($id, $request)
	{

        $user = auth()->user();
        
        $account_no = $request->account_no;

        //get the payment record
        $data = Payment::where('id', $id);
        if ($user->hasRole('administrator')) {
            $company_id = $user->company->id;
            $data = $data->where('company_id', $company_id);
        }
        $data = $data->first();
        //dd($data);

        //if data exists, update
        if ($data){

            //is record processed?
            if ($data->processed){
                //record already processed, show error
                $record_already_processed_error_code = config('constants.settings.status_codes.error_codes.common.record_already_processed');
                $message = "Record already processed";
                return show_json_error($message, $record_already_processed_error_code);
            }

            //update record
            $updated_by = $user->id;
            $updated_by_name = $user->first_name . " " . $user->last_name;
            
            $payment_update = $data
                ->update([
                    'account_no' => $account_no,
                    'modified' => '1',
                    'updated_by' => $updated_by,
                    'updated_by_name' => $updated_by_name
                ]); 

            //get payment data
            $payment_data = Payment::findOrFail($id);

            //fire payment update event
            event(new PaymentUpdated($payment_data));

        } else {

            abort(404);

        }

        $message = "Record successfully updated";
        return show_json_success($message);

	}

}