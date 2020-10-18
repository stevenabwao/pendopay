<?php

namespace App\Http\Controllers\Api\Mpesa;

use App\Entities\MpesaIncoming;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Transformers\Mpesa\MpesaIncomingTransformer;
use Carbon\Carbon;
use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Http\Response\paginator;
use Illuminate\Database\Eloquent\paginate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MpesaIncomingController extends BaseController
{

    //get mpesa incoming payments 
    public function getPayments(Request $request)
    {
        
        //dd($request);
        //generate reports??
        $report = false;

        $invalid_paybill_number_msg = config('constants.error_messages.invalid_paybill_number');

        $paybills_array = [];

        //get url params
        $paybills = $request->paybills;
        
        //get paybills separated by commas, store in array
        if ($paybills) { 
            //trim all whitespaces in array values
            $paybills_array = array_map('trim', explode(',', $paybills)); 

            //check for valid paybill number
            /*foreach ($paybills_array as $element) {
              if (!is_int($element)) {
                // not an integer value, throw error
                throw new ResourceException($invalid_paybill_number_msg);
                break;
              } 
            }*/
        }
        

        $id = $request->id;
        $report = $request->report;
        $phone_number = $request->phone_number;
        $account_name = $request->account_name;
        $start_date = $request->start_date;
        if ($start_date) { $start_date = Carbon::parse($request->start_date); }
        $end_date = $request->end_date;
        if ($end_date) { $end_date = Carbon::parse($request->end_date); }

        //create new mpesa object
        $mpesaIncoming = new MpesaIncoming();
        
        //filter results
        if ($id) { $mpesaIncoming = $mpesaIncoming->where('id', $id); }
        if ($phone_number) { 
            //format the phone number
            $phone_number = formatPhoneNumber($phone_number);
            $mpesaIncoming = $mpesaIncoming->where('msisdn', $phone_number); 
        }
        if ($paybills) { $mpesaIncoming = $mpesaIncoming->whereIn('biz_no', $paybills_array); }
        if ($account_name) { $mpesaIncoming = $mpesaIncoming->where('acc_name', $account_name); }
        if ($start_date) { 
            $mpesaIncoming = $mpesaIncoming->where('date_stamp', '>=', $start_date); 
        }
        if ($end_date) { 
            $mpesaIncoming = $mpesaIncoming->where('date_stamp', '<=', $end_date); 
            //$mpesaIncoming = $mpesaIncoming->where('date_stamp', '=', formatDisplayDate($end_date)); 
        }

        $mpesaIncoming = $mpesaIncoming->orderBy('date_stamp', 'desc');

        if (!$report) {
            $mpesaIncoming = $mpesaIncoming->paginate($request->get('limit', config('app.pagination_limit')));

            return $this->response->paginator($mpesaIncoming, new MpesaIncomingTransformer());
        }
        
        $mpesaIncoming = $mpesaIncoming->get();
        //dd($mpesaIncoming);
        return $this->response->collection($mpesaIncoming, new MpesaIncomingTransformer());

    }

}
