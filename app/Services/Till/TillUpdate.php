<?php

namespace App\Services\Till;

use App\Entities\Till;
use App\Entities\TillType;
use App\Entities\Company;
use Illuminate\Support\Facades\DB;

class TillUpdate
{

    public function updateItem($id, $attributes) {


        //dd($attributes);

        DB::beginTransaction();

        $till_number = "";
        $phone_number = "";
        $company_id = "";
        $till_name = "";
        $status_id = "";

        if (array_key_exists('till_number', $attributes)) {
            $till_number = $attributes['till_number'];
        }
        if (array_key_exists('phone_number', $attributes)) {
            $phone_number = $attributes['phone_number'];
        }
        if (array_key_exists('company_id', $attributes)) {
            $company_id = $attributes['company_id'];
        }
        if (array_key_exists('till_name', $attributes)) {
            $till_name = $attributes['till_name'];
        }
        if (array_key_exists('status_id', $attributes)) {
            $status_id = $attributes['status_id'];
        }

        // convert phone number
        $phone_number = getDatabasePhoneNumber($phone_number);
        $attributes['phone_number'] = $phone_number;
        // dd("attr ", $attributes);

        // check if till number already exists in company
        if (tillExistsForCompany($till_number, $company_id, $id)) {
            $company_data = getCompanyData($company_id);
            $message = "Till $till_number already exists for company";
            if ($company_data) {
                $message .= " $company_data->name";
            }
            $response["message"] = $message;
            return show_json_error($response);
        }

        // check if phone till already exists in company
        if (phoneTillExistsForCompany($phone_number, $company_id, $id)) {
            $company_data = getCompanyData($company_id);
            $message = "Phone $phone_number till already exists for company";
            if ($company_data) {
                $message .= " $company_data->name";
            }
            $response["message"] = $message;
            return show_json_error($response);
        }

        //save new record
        try {

            //dd($attributes);
            $existing_till = new Till();
            $result = $existing_till->updatedata($id, $attributes);
            //dd($result);

            log_this(">>>>>>>>> SNB SUCCESS UPDATING TILL :\n\n" . json_encode($result) . "\n\n\n");
            if ($result) {
                $response["message"] = "Till successfully updated";
            } else {
                $response["message"] = "Could not update till. " . json_encode($result);
                return show_json_error($response);
            }

            $response = show_json_success($response);

         } catch(\Exception $e) {

            //dd($e);
            DB::rollback();
            $message = $e->getMessage();
            return show_json_error($message);

        }

        DB::commit();

        return $response;

    }

}
