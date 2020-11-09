<?php

namespace App\Services\MyTransaction;

use App\Entities\Transaction;
use Illuminate\Support\Facades\DB;

class MyTransactionStore
{

    public function createItem($attributes) {
        // dd($attributes);

        $response = [];

        DB::beginTransaction();

        $transaction_role = "";

        if (array_key_exists('transaction_role', $attributes)) {
            $transaction_role = $attributes['transaction_role'];
        }

        // get logged user
        $logged_user = getLoggedUser();

        // check the role
        $transaction_role_message = "";
        if ($transaction_role == getTransactionRoleBuyer()) {
            $attributes['buyer_user_id'] = $logged_user->id;
            $transaction_role_message = getSelectTransactionSellerText();
        } else if ($transaction_role == getTransactionRoleSeller()) {
            $attributes['seller_user_id'] = $logged_user->id;
            $transaction_role_message = getSelectTransactionBuyerText();
        }

        // add status_id
        $attributes['status_id'] = getStatusInactive();

        // rearrange date
        $attributes['transaction_date'] = reArrangeSubmittedDate($attributes['transaction_date']);

        // add creator and updater
        $attributes['created_by'] = $logged_user->id;
        $attributes['created_by_name'] = $logged_user->full_name;
        $attributes['updated_by'] = $logged_user->id;
        $attributes['updated_by_name'] = $logged_user->full_name;

        unset($attributes['terms']);

        // dd($attributes);

        // start create new trans
        try {

            $new_trans = new Transaction();
            $trans_result = $new_trans->create($attributes);
            $trans_result->trans_message = $transaction_role_message;

            $response["error"] = false;
            $success_message = 'Successfully created transaction - ' . $trans_result->title . " - ";
            $success_message .= $transaction_role_message;
            $response["message"] = $success_message;
            $response["data"] = $trans_result;

        } catch(\Exception $e) {

            DB::rollback();
            //dd($e);
            $message = $e->getMessage();
            log_this(">>>>>>>>> ERROR CREATING OFFER VIA API :\n\n" . formatErrorJson($e) . "\n\n\n");
            throw new \Exception($message);

        }
        //end create new offer

        // show success
        $response = show_success_response($response);

        DB::commit();

        return $response;

    }

}