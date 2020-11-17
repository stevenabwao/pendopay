<?php

namespace App\Services\MyTransaction;

use App\Entities\Transaction;
use Illuminate\Support\Facades\DB;

class MyTransactionStoreStepTwo
{

    public function createItem($attributes) {

        $response = [];

        $partner_details_select = "";
        $transaction_partner_details = "";

        if (array_key_exists('partner_details_select', $attributes)) {
            $partner_details_select = $attributes['partner_details_select'];
        }
        if (array_key_exists('transaction_partner_details', $attributes)) {
            $transaction_partner_details = $attributes['transaction_partner_details'];
        }

        if (isLoggedUserDetails($partner_details_select, $transaction_partner_details)) {
            $message = "You cannot use your details for the other transaction partner. Please enter transaction partner details instead";
            log_this($message . "\n\n\n");
            throw new \Exception($message);
        }

        // use provided details to locate partner
        try {
            $user_data = getTransUserData($partner_details_select, $transaction_partner_details);
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        if (!$user_data) {
            $sent_field_name = getSentFieldName($partner_details_select);
            $message = "User not found on Pendopay with $sent_field_name : $transaction_partner_details";
            log_this($message . "\n\n\n");
            $response["error"] = true;
            $response["message"] = $message;
            return show_error_response($response);
        } else {
            $response["error"] = false;
            $response["data"] = $user_data;
        }

        // show success
        $response = show_success_response($response);

        return $response;

    }

}
