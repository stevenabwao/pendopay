<?php

namespace App\Services\Payment;

use App\Entities\Payment;
use App\Entities\PaymentDeposit;
use App\Services\Shares\SharesDepositStore;
use App\Services\Payment\PaymentDepositStore;
use App\Services\LoanRepayment\LoanRepaymentStore;
use Carbon\Carbon;
use Mail;
use Illuminate\Support\Facades\DB;

class PaymentRequestStore
{

    // send mpesa payment request to user
    public function createItem($attributes) {

        $response = [];

        // dd($attributes);

        $shopping_cart_id = "";
        $amount = "";
        $phone_number = "";
        $user_id = "";

        if (array_key_exists('order_id', $attributes)) {
            $shopping_cart_id = $attributes['order_id'];
        }
        if (array_key_exists('amount', $attributes)) {
            $amount = $attributes['amount'];
        }
        if (array_key_exists('phone_number', $attributes)) {
            $phone_number = $attributes['phone_number'];
            $phone_number = getDatabasePhoneNumber($phone_number);
        }
        if (array_key_exists('user_id', $attributes)) {
            $user_id = $attributes['user_id'];
        }

        // site settings
        $site_settings = getSiteSettings();

        // barddy paybill
        $barddy_paybill_number = $site_settings['barddy_paybill_number'];

        // get company id from order
        // $shopping_cart_data = getShoppingCart($user_id, "", $shopping_cart_id);
        $statuses_array = array();
        $statuses_array[] = getStatusOrderPlaced();
        $statuses_array[] = getStatusActive();
        $shopping_cart_data = getShoppingCart($user_id, "", $shopping_cart_id, $statuses_array);
        // dd($shopping_cart_data);

        // proceed only if data is found
        if($shopping_cart_data) {

            $company_id = $shopping_cart_data->company_id;
            $shopping_cart_id = $shopping_cart_data->id;
            $offer_id = $shopping_cart_data->offer_id;

            //start transaction
            DB::beginTransaction();

                //if account_no is entered, use the submitted account_no/ phone
                $account_data = getUserData($phone_number);

                if (!$account_data) {

                    // show error
                    $message = "User Account not found";
                    return show_error_response($message);

                }

                // send stk push request to user phone
                try {

                    sendStkPushRequest($barddy_paybill_number, $phone_number, $shopping_cart_id, $amount, $company_id, $offer_id, $user_id);

                } catch(\Exception $e) {

                    DB::rollBack();
                    dd($e);
                    log_this(json_encode($e));
                    $message = "An error occured. Could not complete order.";
                    return show_error_response($message);

                }

                $message = "Mpesa payment request has been sent to your phone {{$phone_number}}. Please wait...";
                $response = show_success_response($message);

            DB::commit();

            return $response;

        } else {

            // show error
            $message = "Invalid shopping cart data found";
            return show_error_response($message);

        }


    }

}
