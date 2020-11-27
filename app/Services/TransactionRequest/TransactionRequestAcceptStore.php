<?php

namespace App\Services\TransactionRequest;

use App\Entities\Transaction;
use App\Entities\TransactionAccount;
use Illuminate\Support\Facades\DB;

class TransactionRequestAcceptStore
{

    public function createItem($attributes) {

        $response = [];

        // get logged user
        $logged_user = getLoggedUser();

        DB::beginTransaction();

        $submit_btn = "";
        $terms = "";
        $transaction_id = "";
        $transaction_request_id = "";

        if (array_key_exists('submit_btn', $attributes)) {
            $submit_btn = $attributes['submit_btn'];
        }
        if (array_key_exists('terms', $attributes)) {
            $terms = $attributes['terms'];
        }
        if (array_key_exists('transaction_id', $attributes)) {
            $transaction_id = $attributes['transaction_id'];
        }
        if (array_key_exists('transaction_request_id', $attributes)) {
            $transaction_request_id = $attributes['transaction_request_id'];
        }

        // if accept is selected, ensure terms box is also selected
        if ($submit_btn == 'accept') {

            if (!$terms) {
                $message = "Please accept transaction terms and conditions to proceed";
                log_this(">>>>>>>>> ERROR ACCEPTING TRANS REQUEST :\n\n" . formatErrorJson($message) . "\n\n\n");
                throw new \Exception($message);
            }

            // start update transaction to active
            try {

                activateTransaction($transaction_id);
                log_this("Transaction ID: $transaction_id status successfully updated to " . getStatusActive());

            } catch(\Exception $e) {

                DB::rollBack();
                log_this(json_encode($e));
                throw new \Exception($e->getMessage());

            }
            // end update transaction to inactive

            // start update transaction request to inactive
            try {

                updateTransactionRequestStatus($transaction_request_id, getStatusInactive());
                log_this("Transaction Request ID: $transaction_request_id status successfully updated to " . getStatusInactive());

            } catch(\Exception $e) {

                DB::rollBack();
                log_this(json_encode($e));
                throw new \Exception($e->getMessage());

            }
            // end update transaction request to inactive

            // send email/ sms to transaction creator
            // send email/ sms to the current user (acceptor)
            // take user to transaction request success page

            $response['data'] = getTransactionData($transaction_id);
            $response['message'] = "Transaction Request Accepted Successfully";

        } else {

            // reject the transaction request
            // send email to transaction creator
            dd("rejected");

        }

        // add creator and updater
        /* $attributes['created_by'] = $logged_user->id;
        $attributes['created_by_name'] = $logged_user->full_name;
        $attributes['updated_by'] = $logged_user->id;
        $attributes['updated_by_name'] = $logged_user->full_name;

        unset($attributes['terms']); */

        // dd($attributes);

        // show success
        $response = show_success_response($response);

        DB::commit();

        // dd("final response == ", $response);
        return $response;

    }

}
