<?php

namespace App\Services\MpesaB2C;

use App\Entities\MpesaB2C;
use App\Services\LoanApplication\LoanApplicationApprove;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MpesaB2CUpdate 
{

    //update mpesa b2c transaction
    public function updateItem($attributes) {

        log_this("return data - " . json_encode($attributes));

        $status_autodeclined = config('constants.status.autodeclined');

        $request_id = "";
        $orig_con_id = "";
        $con_id = "";
        $trans_id = "";
        $utility_bal = "";
        $trans_status = "";
        $rx_fullname = "";
        $receiver = "";
        $completed_time = "";
        $src_ip = "";

        if (array_key_exists('request_id', $attributes)) {
            $request_id = $attributes['request_id'];
        }
        if (array_key_exists('orig_con_id', $attributes)) {
            $orig_con_id = $attributes['orig_con_id'];
        }
        if (array_key_exists('con_id', $attributes)) {
            $con_id = $attributes['con_id'];
        }
        if (array_key_exists('trans_id', $attributes)) {
            $trans_id = $attributes['trans_id'];
        }
        if (array_key_exists('utility_bal', $attributes)) {
            $utility_bal = $attributes['utility_bal'];
        }
        if (array_key_exists('trans_status', $attributes)) {
            $trans_status = $attributes['trans_status'];
        }
        if (array_key_exists('rx_fullname', $attributes)) {
            $rx_fullname = $attributes['rx_fullname'];
        }
        if (array_key_exists('receiver', $attributes)) {
            $receiver = $attributes['receiver'];
        }
        if (array_key_exists('completed_time', $attributes)) {
            $completed_time = $attributes['completed_time'];
        }
        if (array_key_exists('src_ip', $attributes)) {
            $src_ip = $attributes['src_ip'];
        }

        //do any extra processing here
        try {

            $mpesab2c_data = MpesaB2C::where("request_id", $request_id)->first();
            $app_name = $mpesab2c_data->app_name;
            
            log_this(json_encode($mpesab2c_data));

            //if trans_status == 'request', update the trans
            if ($trans_status == 'request') {
                
                $mpesab2c_update = $mpesab2c_data
                        ->update([
                            'orig_con_id' => $orig_con_id
                        ]);

            }

            //if trans_status == 'result', final update the trans result
            if ($trans_status == 'result') {
                
                $mpesab2c_update = $mpesab2c_data
                        ->update([
                            'con_id' => $con_id,
                            'trans_id' => $trans_id,
                            'trans_status' => $trans_status,
                            'utility_bal' => $utility_bal,
                            'rx_fullname' => $rx_fullname,
                            'receiver' => $receiver,
                            'completed_time' => $completed_time,
                            'src_ip' => $src_ip
                        ]);

                        
                        //$success = "";

                        if ($request_id) {
                            
                            $approve_attributes['trans_status'] = $trans_status;

                            //attempt to approve the loan
                            $loan_application_approve = new LoanApplicationApprove();
                            $result = $loan_application_approve->approveItem($request_id, $approve_attributes);

                            //dd($result); 

                            $result_json = json_decode($result);
                            $response = $result_json->message;

                       }

            }

            log_this("\n\n\n************ MPESAB2CSTORE SENT RESPONSE ************\n\n" 
                . "\n\n" . json_encode($mpesab2c_update) . "\n\n" . "************\n\n\n");

            return $mpesab2c_update;

        } catch(\Exception $e) {

             $message = "Error: " . $e->getMessage();
             log_this("\n\n\n************ MPESAB2CSTORE SENT ERROR RESPONSE ************\n\n" 
                . json_encode($message) . "\n\n\n" . "************\n\n\n\n\n");

        }

   }

}