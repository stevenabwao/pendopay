<?php

namespace App\Services\Transfer;

use App\Entities\Transfer;
use Illuminate\Support\Facades\DB;
use App\Entities\DepositAccountSummary;
use App\Entities\DepositAccountHistory;
use App\Services\Payment\PaymentStore;

class TransferAccountCheck
{

    public function createItem($request) {

        $response = [];

        $logged_user = getLoggedUser();

        // DB::beginTransaction();

            $destination_account_type = "";
            $destination_account_no = "";

            if ($request->has('destination_account_type')) {
                $destination_account_type = $request->destination_account_type;
            }
            if ($request->has('destination_account_no')) {
                $destination_account_no = $request->destination_account_no;
            }

            // check if the destination account can be found
            try {

                $destination_account_data = getDestinationAccountData($destination_account_type, $destination_account_no);

            } catch(\Exception $e) {

                $error_message = $e->getMessage();
                log_this($error_message);
                throw new \exception($error_message);

            }

            // do we have a destination account?
            if ($destination_account_data) {

                // if its a transaction account
                // if transaction status is not active, throw an error
                if ($destination_account_data->transaction->status_id != getStatusActive()) {
                        $error_message = trans('general.invalidtransactionstatus');
                        log_this($error_message . "\n" . json_encode($request->all()));
                        throw new \Exception($error_message);
                }

                // check if logged in user is a buyer in transaction
                // if user is not a buyer, throw an error
                if (($destination_account_type == getAccountTypeTransactionAccount())
                    && ($logged_user->id != $destination_account_data->buyer_user_id)) {
                        $error_message = trans('general.cannottransferifnotbuyer');
                        log_this($error_message . "\n" . json_encode($request->all()));
                        throw new \Exception($error_message);
                }

                $response['data'] = $destination_account_data;

            } else {
                $error_message = trans('general.destinationaccountnotfound');
                log_this($error_message . "\n" . json_encode($request->all()));
                throw new \Exception($error_message);
            }
            // dd("destination_account_data pitaa == ", $destination_account_data);

        // DB::commit();

        $response['message'] = "Success";
        return show_json_success($response);

    }

}
