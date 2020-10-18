<?php

namespace App\Services\MpesaC2B;


class StkPushStore 
{

    // store the new stk push transaction
    public function save($request) {

        // get params
        $msisdn = $request->phone_number;
        $acc_ref = $request->acct_no;

        if (!$acc_ref) {
            $acc_ref = $msisdn;
        }

        $request->merge([
            'acc_ref' => $acc_ref
        ]);

        // dd("Below My request here -- ", $request->all());

        try {

            // call remote stkpush
            $response = sendStkPush($request);

            // dd("response === ", response);

            log_this("\n\n\n************ MPESAC2BSTORE SENT RESPONSE ************\n\n" 
                . json_encode($request->all()) . "\n\n" . json_encode($response) . "\n\n\n" . "************\n\n\n\n\n");

            return $response;

        } catch(\Exception $e) {

             $message = "Error: " . $e->getMessage();
             log_this("\n\n\n************ MPESAC2BSTORE SENT ERROR RESPONSE ************\n\n" 
                . json_encode($message) . "\n\n\n" . "************\n\n\n\n\n");

        }

   }

}