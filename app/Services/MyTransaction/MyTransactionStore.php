<?php

namespace App\Services\MyTransaction;

use App\Entities\Transaction;
use Illuminate\Support\Facades\DB;

class MyTransactionStore
{

    public function createItem($attributes) {
        // dd($attributes);

        /*
        "title" => "Sale of Furniture"
        "transaction_amount" => "30000"
        "transaction_date" => "08-12-2020"
        "transaction_role" => "seller"
        "terms" => "on"
        */

        $response = [];

        DB::beginTransaction();

        $transaction_role = "";

        if (array_key_exists('transaction_role', $attributes)) {
            $transaction_role = $attributes['transaction_role'];
        }

        // get logged user
        $logged_user = getLoggedUser();

        // check the role
        if ($transaction_role == 'buyer') {
            $attributes['buyer_user_id'] = $logged_user->id;
        } else if ($transaction_role == 'seller') {
            $attributes['seller_user_id'] = $logged_user->id;
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

            $response["error"] = false;
            $response["message"] = 'Successfully created transaction titled - ' . $trans_result->title;
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
