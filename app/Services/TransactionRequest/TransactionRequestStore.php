<?php

namespace App\Services\TransactionRequest;

use App\Entities\Transaction;
use App\Entities\TransactionAccount;
use Illuminate\Support\Facades\DB;

class TransactionRequestStore
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
            log_this(">>>>>>>>> ERROR CREATING TRANS :\n\n" . formatErrorJson($e) . "\n\n\n");
            throw new \Exception($message);

        }
        //end create new trans

        // start create new trans account
        try {

            $new_trans_account = new TransactionAccount();


            $new_trans_account_attributes['transaction_id'] = $trans_result->id;
            $new_trans_account_attributes['account_no'] = generate_account_number(getDefaultCompanyId(),
                                                                                    getDefaultBranchCd(),
                                                                                    $logged_user->id,
                                                                                    getTransactionAccountTypeId());
            $new_trans_account_attributes['account_name'] = $trans_result->title;

            // if creator is a buyer, enter buyer details
            // else enter seller details
            if ($transaction_role == getTransactionRoleBuyer()) {
                $new_trans_account_attributes['buyer_user_id'] = $logged_user->id;
                $new_trans_account_attributes['buyer_accepted_at'] = getUpdatedDate();
            } else {
                $new_trans_account_attributes['seller_user_id'] = $logged_user->id;
                $new_trans_account_attributes['seller_accepted_at'] = getUpdatedDate();
            }

            $new_trans_account_attributes['opened_at'] = getUpdatedDate();
            $new_trans_account_attributes['available_at'] = getUpdatedDate();
            $new_trans_account_attributes['status_id'] = getStatusActive();
            $new_trans_account_attributes['created_by'] = $logged_user->id;
            $new_trans_account_attributes['created_by_name'] = $logged_user->full_name;
            $new_trans_account_attributes['updated_by'] = $logged_user->id;
            $new_trans_account_attributes['updated_by_name'] = $logged_user->full_name;
            // dd($new_trans_account_attributes);

            $trans_account_result = $new_trans_account->create($new_trans_account_attributes);
            // dd("trans_account_result == ", $trans_account_result);
            log_this(">>>>>>>>> SUCCESS CREATING TRANS ACCOUNT :\n\n" . formatErrorJson($trans_account_result) . "\n\n\n");

        } catch(\Exception $e) {

            DB::rollback();
            //dd($e);
            $message = $e->getMessage();
            log_this(">>>>>>>>> ERROR CREATING TRANS ACCOUNT :\n\n" . formatErrorJson($e) . "\n\n\n");
            throw new \Exception($message);

        }
        //end create new trans account

        // show success
        $response = show_success_response($response);

        DB::commit();

        return $response;

    }

}
