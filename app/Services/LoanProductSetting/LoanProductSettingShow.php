<?php

namespace App\Services\LoanProductSetting;

use App\Entities\LoanProductSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoanProductSettingShow 
{

    public function showItem($id) {

        DB::beginTransaction(); 

        //show record
        try {

            //get details
            $response = LoanProductSetting::find($id);

            $interest_cycle = "";
            $approved_interest_cycle = "";
            $currency = "";

            //get the interest type, interest method, interest cycle and period
            $interest_type = $response->interest_type;
            $interest_method = $response->interest_method;
            $approved_interest_type = $response->approved_interest_type;
            $approved_interest_method = $response->approved_interest_method;
            if ($response->interestcycle) {
                $interest_cycle = $response->interestcycle->name_2;
            }
            if ($response->approvedinterestcycle) {
                $approved_interest_cycle = $response->approvedinterestcycle->name_2;
            }
            $interest_amount = $response->interest_amount;
            $approved_interest_amount = $response->approved_interest_amount;

            //get the interest amount char
            if ($interest_type == 'percentage') {
                $interest_amount_char = $interest_amount . "%";
            } else {
                //get the currency
                if ($response->currency) {
                    $currency = $response->currency->initials;
                }
                $interest_amount_char = $currency . " " . $interest_amount;
            }

            //get the approved interest amount char
            if ($approved_interest_type == 'percentage') {
                $approved_interest_amount_char = $approved_interest_amount . "%";
            } else {
                //get the currency
                if ($response->currency) {
                    $currency = $response->currency->initials;
                }
                $approved_interest_amount_char = $currency . " " . $approved_interest_amount;
            }

            $interest_amount_full_text = $interest_amount_char . " " . $interest_cycle;
            $approved_interest_amount_full_text = $approved_interest_amount_char . " " . $approved_interest_cycle;

            $response->interest_amount_full_text = $interest_amount_full_text;
            $response->approved_interest_amount_full_text = $approved_interest_amount_full_text;

            // dd($response);

            // $response = show_json_success($response);

         } catch(\Exception $e) { 

            DB::rollback();
            $message = $e->getMessage();
            return show_json_error($message);

        }

        DB::commit();

        return $response;

    }

}