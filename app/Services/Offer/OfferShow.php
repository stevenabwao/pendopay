<?php

namespace App\Services\LoanApplication;

use App\Entities\LoanApplication;
use App\Entities\LoanProductSetting;
use App\Entities\DepositAccount;
use App\Entities\Currency;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OfferShow
{

    public function showItem($id) {

        DB::beginTransaction();

        //show record
        try {

            //get details for this ussd reg
            $response = LoanApplication::find($id);

            $interest_cycle = "";
            $currency = "";

            //get the interest type, interest method, interest cycle and period
            $interest_type = $response->interest_type;
            $interest_method = $response->interest_method;
            if ($response->interestcycle) {
                $interest_cycle = $response->interestcycle->name_2;
            }
            $interest_amount = $response->interest_amount;

            //get the interest amount char
            if ($interest_type == 'percentage') {
                $interest_amount_char = $interest_amount . "%";
            } else {
                //get the currency
                if ($response->currency) {
                    $currency = $response->currency->initials;
                }
                $interest_amount_char = currency . " " . $interest_amount;
            }

            $interest_amount_full_text = $interest_amount_char . " " . $interest_cycle;

            $response->interest_amount_full_text = $interest_amount_full_text;

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
