<?php

namespace App\Services\MyTransaction;

use App\Entities\Transaction;
use Illuminate\Support\Facades\DB;

class MyTransactionStoreStepThree
{

    public function createItem($attributes) {

        $response = [];

        $user_id = "";
        $trans_id = "";
        $transaction_partner_role = "";

        if (array_key_exists('user_id', $attributes)) {
            $user_id = $attributes['user_id'];
        }
        if (array_key_exists('trans_id', $attributes)) {
            $trans_id = $attributes['trans_id'];
        }
        if (array_key_exists('transaction_partner_role', $attributes)) {
            $transaction_partner_role = $attributes['transaction_partner_role'];
        }

        // get transaction data
        $transaction_data = getTransactionData($trans_id, getStatusInactive());

        if (!$transaction_data) {
            throw new \Exception("Invalid transaction status");
        }

        // get sender user data
        $sender_user_data = getLoggedUser();

        // check if we are sending to an existing user or a new user
        if ($user_id) {

            // this is an existing PendoPay user

            // get recipient user data
            $recipient_user_data = getUserData("","", $user_id);

            // send email request to user
            sendTransactionRequestEmail($sender_user_data, $recipient_user_data, $transaction_data);

            // TODO: change transaction status to pending
            // changeTransactionStatus($trans_id, getStatusPending());

            // TODO: save entry into transaction requests table

            $response['message'] = "Transaction request successfully sent";

        } else {

            // user is not on PendoPay

        }

        dd("res == ", $response);

        /* if (isLoggedUserDetails($partner_details_select, $transaction_partner_details)) {
            $message = "You cannot use your details for the other transaction partner. Please enter transaction partner details instead";
            log_this($message . "\n\n\n");
            throw new \Exception($message);
        } */

        // use provided details to locate partner
        /* try {
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
        } */

        // show success
        $response = show_success_response($response);

        return $response;

    }

}
