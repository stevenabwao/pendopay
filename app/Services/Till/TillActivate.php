<?php

namespace App\Services\Till;

use App\Entities\Till;
use App\Entities\TillType;
use App\Entities\Company;
use App\Entities\ConfirmCode;
use Illuminate\Support\Facades\DB;

class TillActivate
{

    public function updateItem($activationCode, $phone_number="") {

        DB::beginTransaction();

        $response = [];

        // check if activation code is valid
        if (!isActivationCodeValid($activationCode, $phone_number)) {
            $message = "Invalid activation code";
            $response["message"] = $message;
            return show_json_error($response);
        }

        // activate phone
        // get confirm code entry data
        $confirm_code_data = getConfirmCodeData($activationCode);

        // get till phone
        $confirm_code_phone = $confirm_code_data->phone;

        // if confirm_code_phone exists, activate phone
        if ($confirm_code_phone) {

            try {

                activatePhoneTill($activationCode, $confirm_code_phone);

                $response["message"] = "Till successfully activated";

                $response = show_json_success($response);

            } catch (\Exception $e) {

                DB::rollback();
                $message = $e->getMessage();
                return show_json_error($message);

            }

        }

        DB::commit();

        return $response;

    }

}
