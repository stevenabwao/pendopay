<?php

namespace App\Services\Transfer;

use App\Entities\Transfer;
use Illuminate\Support\Facades\DB;
use App\Entities\DepositAccountSummary;
use App\Entities\DepositAccountHistory;
use App\Services\Payment\PaymentStore;

class TransferAccountCheckConfirm
{

    public function createItem($request) {

        $response = [];
        $destination_account_data = NULL;

        $logged_user = getLoggedUser();

        // DB::beginTransaction();

            $destination_account_type = "";
            $destination_account_no = "";
            $transfer_amount = "";

            if ($request->has('destination_account_type')) {
                $destination_account_type = $request->destination_account_type;
            }
            if ($request->has('destination_account_no')) {
                $destination_account_no = $request->destination_account_no;
            }
            if ($request->has('transfer_amount')) {
                $transfer_amount = $request->transfer_amount;
            }

            // check if the destination account can be found
            try {

                $destination_account_data = getDestinationAccountData($destination_account_type, $destination_account_no);

            } catch(\Exception $e) {

                $error_message = $e->getMessage();
                log_this($error_message);
                throw new \exception($error_message);

            }

            // if its a transaction account
            // check if logged in user is a buyer in transaction
            // if user is not a buyer, throw an error
            if ($destination_account_type == getAccountTypeTransactionAccount()){

                // get the transaction account balance
                // show an error if the transfer being done is more than transaction account balance
                $transaction_account_balance = $destination_account_data->transaction->transaction_balance;

                // if transfer amount exceed transaction_account_balance, throw error
                if ($transfer_amount > $transaction_account_balance) {
                    $transfer_amount_fmt = formatCurrency($transfer_amount);
                    $transaction_account_balance_fmt = formatCurrency($transaction_account_balance);
                    $error_message = trans('general.excesstransferamount', ['transfer_amount' => $transfer_amount_fmt,
                                                                'account_balance' => $transaction_account_balance_fmt]);
                    log_this($error_message);
                    throw new \exception($error_message);
                }

                // if transfer amount is more than what the client has in their wallet, throw error
                if ($transfer_amount > getUserDepositAccountBalance()) {
                    $transfer_amount_fmt = formatCurrency($transfer_amount);
                    $wallet_balance_fmt = formatCurrency(getUserDepositAccountBalance());
                    $error_message = trans('general.excesstransferamountthanwallet', ['transfer_amount' => $transfer_amount_fmt,
                                                                'wallet_balance' => $wallet_balance_fmt]);
                    log_this($error_message);
                    throw new \exception($error_message);
                }
                // dd("transaction_account_balance == ", $transaction_account_balance);

            }
            // dd("destination_account_data pitaa == ", $destination_account_data);

        // DB::commit();

        $response['message'] = "Success";
        return show_json_success($response);

    }

}
