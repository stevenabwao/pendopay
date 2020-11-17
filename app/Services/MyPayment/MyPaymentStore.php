<<<<<<< HEAD
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
||||||| merged common ancestors
=======
<?php

namespace App\Services\MyPayment;

use App\Entities\Transaction;
use App\Entities\TransactionAccount;
use Illuminate\Support\Facades\DB;

class MyPaymentStore
{

    public function createItem($attributes) {

        // dd($attributes);

        $response = [];

        DB::beginTransaction();

        $logged_user = getLoggedUser();

        $phone = "";
        $amount = "";

        if (array_key_exists('phone', $attributes)) {
            $phone = getDatabasePhoneNumber($attributes['phone']);
            $attributes['phone'] = $phone;
        }
        if (array_key_exists('amount', $attributes)) {
            $amount = format_num($attributes['amount'], 0, "");
            $attributes['amount'] = $amount;
        }

        // send stk push request to user phone
        // get user settings
        $site_settings = getSiteSettings();
        try {

            $paybill_number = $site_settings['paybill_number'];
            $company_id = $site_settings['company_id'];
            $account_no = $phone;
            $user_id = $logged_user->id;
            sendStkPushRequest($paybill_number, $phone, $account_no, $amount, $company_id, $user_id);

            $message = "Mpesa payment request sent successfully";
            $response['message'] = $message;

        } catch(\Exception $e) {

            DB::rollBack();
            // dd($e);
            log_this(json_encode($e));
            $message = "An error occured. Could not complete mpesa payment";
            throw new \Exception($message);

        }

        // show success
        $response = show_success_response($response);

        DB::commit();

        return $response;

    }

}
>>>>>>> master
