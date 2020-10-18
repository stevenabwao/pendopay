<?php

namespace App\Services\MpesaPaybill;

use App\Entities\MpesaPaybill;
use App\Entities\GroupMember;
use App\Entities\CompanyBranch;
use App\Entities\CompanyUser;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MpesaPaybillStore
{

    use Helpers;

    public function createItem($attributes) {

        //dd($attributes);

        DB::beginTransaction();

        $paybill_number = "";
        $company_id = "";

        //check if mpesa paybill already exists
        $pesa_paybill_data = MpesaPaybill::where('company_id', $company_id)
                                    ->where('paybill_number', $paybill_number)
                                    ->first();
        if ($pesa_paybill_data){
            //error here
            $message = "Mpesa Paybill already exists for company";
            return show_json_error($message);
        }

        //save new remote record
        try {

            $remote_result_data = createRemoteMpesaPaybill($attributes);

            //dd($remote_result_data);

            $remote_response = show_json_success($remote_result_data);

         } catch(\Exception $e) { 

            //dd($e);
            DB::rollback();
            $message = $e->getMessage();
            return show_json_error($message);

        }

        if ($remote_result_data) {

            //save new local record
            try {

                $new_mpesa_paybill = new MpesaPaybill();

                $response = $new_mpesa_paybill->create($attributes);

                $response = show_json_success($response);

            } catch(\Exception $e) { 

                //dd($e);
                DB::rollback();
                $message = $e->getMessage();
                return show_json_error($message);

            }

        }

        DB::commit();

        return $response;

    }

}
