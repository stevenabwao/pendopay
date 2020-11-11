<?php

namespace App\Services\MyTransaction;

use App\Entities\Transaction;
use Illuminate\Support\Facades\DB;

class MyTransactionStoreStepThree
{

    public function createItem($attributes) {

        $response = [];

        DB::beginTransaction();

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
            try {

                sendTransactionRequestEmail($sender_user_data, $recipient_user_data, $transaction_data);

            } catch(\Exception $e) {

                DB::rollback();
                log_this($e);
                throw new \Exception($e->getMessage());

            }

            // save entry into transaction requests table
            try {

                saveNewTransactionRequest($sender_user_data, $recipient_user_data, $transaction_data);

            } catch(\Exception $e) {

                DB::rollback();
                log_this($e);
                throw new \Exception($e->getMessage());

            }

            // change transaction status to pending
            try {

                changeTransactionStatus($trans_id, getStatusPending());

            } catch(\Exception $e) {

                DB::rollback();
                log_this($e);
                throw new \Exception($e->getMessage());

            }

            $response['message'] = "Transaction request successfully sent";

        } else {

            // user is not on PendoPay

        }

        // dd("res == ", $response);

        // show success
        $response = show_success_response($response);

        DB::commit();

        return $response;

    }

}
