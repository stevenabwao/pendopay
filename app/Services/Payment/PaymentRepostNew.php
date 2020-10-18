<?php

namespace App\Services\Payment;

use App\Entities\Payment;
use App\Services\Payment\PaymentStore;
use App\Events\PaymentUpdated;
use Illuminate\Support\Facades\DB;

class PaymentRepostNew
{

	public function updateItem($id, $request)
	{

        DB::enableQueryLog();

        $user = auth()->user();
        
        //get the payment record
        $data = Payment::find($id);
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

            try {

                //repost record
                $paymentStore = new PaymentStore();

                $attributes['id'] = $id;
                $attributes['payment_id'] = $id;
                $attributes['reposted_by_name'] = $user->first_name . " " . $user->last_name;
                $attributes['reposted_by'] = $user->id;
                //dd($attributes);

                $result = $paymentStore->createItem($attributes);

                //dd($data, $result);

                $result = json_decode($result);
                $result_message = $result->message;
                //dd($result);

                //dd(DB::getQueryLog());


            } catch (\Exception $e) {

                dd($e);

            }

            if (!$result->error) {
                $message = "Record successfully updated";
                return show_json_success($message);
            } else {
                return show_json_error($result_message);
            }

        } else {

            abort(404);

        }


	}

}