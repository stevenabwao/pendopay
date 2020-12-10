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
        // get site settings
        $site_settings = getSiteSettings();

        // get logged in user phone
        $logged_user_phone = $logged_user->phone;
        $logged_user_id = $logged_user->id;

        try {

            $paybill_number = $site_settings['paybill_number'];
            $company_id = $site_settings['company_id'];
            $account_no = $logged_user_phone;
            sendStkPushRequest($paybill_number, $phone, $account_no, $amount, $company_id, $logged_user_id);

            $message = "Mpesa payment request sent successfully";
            $response['message'] = $message;

        } catch(\Exception $e) {

            DB::rollBack();
            // dd($e);
            log_this(json_encode($e));
            $message = trans('general.paymentfailed');
            throw new \Exception($message);

        }

        // show success
        $response = show_success_response($response);

        DB::commit();

        return $response;

    }

}
