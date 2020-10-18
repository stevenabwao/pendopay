<?php

namespace App\Services\Shares;

use App\Entities\Account;
use App\Entities\Company;
use App\Entities\CompanyUser;
use App\Entities\DepositAccount;
use App\Entities\SharesAccount;
use App\Services\Shares\SharesStore;
use App\User;
use Carbon\Carbon;
use Mail;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;

class SharesDepositStore
{

    use Helpers;

    public function createItem($payment_id, $attributes) {

        //dd($attributes);

        //DB::enableQueryLog();

        //current date and time
        $date = Carbon::now();
        //$date = getLocalDate($date);
        $date = $date->toDateTimeString();

        $shares_product_id = config('constants.account_settings.shares_account_product_id');
        $status_active = config('constants.status.active');
        $status_disabled = config('constants.status.disabled');
        $shares_gl_account_type_id = config('constants.gl_account_types.shares');

        DB::beginTransaction();

            //get sent details
            $paybill_number = "";
            $full_name = "";
            $company_id = "";
            $account_no = "";
            $amount = "";
            $mpesa_code = "";
            $trans_id = "";
            $src_ip = "";
            $transfer = "";
            $tran_ref_txt = "";
            $tran_desc = "";
            $payment_id = "";
            $payment_name = "";
            $modified = "";

            if (array_key_exists('account_no', $attributes)) {
                $account_no = $attributes['account_no'];
            }
            if (array_key_exists('phone', $attributes)) {
                $phone = $attributes['phone'];
            }
            if (array_key_exists('amount', $attributes)) {
                $amount = $attributes['amount'];
            }
            if (array_key_exists('paybill_number', $attributes)) {
                $paybill_number = $attributes['paybill_number'];
            }
            if (array_key_exists('full_name', $attributes)) {
                $full_name = $attributes['full_name'];
            }
            if (array_key_exists('src_ip', $attributes)) {
                $src_ip = $attributes['src_ip'];
            }
            if (array_key_exists('trans_id', $attributes)) {
                $trans_id = $attributes['trans_id'];
            }
            if (array_key_exists('company_id', $attributes)) {
                $company_id = $attributes['company_id'];
            }
            if (array_key_exists('transfer', $attributes)) {
                $transfer = $attributes['transfer'];
            }
            if (array_key_exists('tran_ref_txt', $attributes)) {
                $tran_ref_txt = $attributes['tran_ref_txt'];
            }
            if (array_key_exists('tran_desc', $attributes)) {
                $tran_desc = $attributes['tran_desc'];
            }
            if (array_key_exists('mpesa_code', $attributes)) {
                $mpesa_code = $attributes['mpesa_code'];
            }
            if (array_key_exists('payment_id', $attributes)) {
                $payment_id = $attributes['payment_id'];
            }
            if (array_key_exists('payment_name', $attributes)) {
                $payment_name = $attributes['payment_name'];
            }
            if (array_key_exists('modified', $attributes)) {
                $modified = $attributes['modified'];
            }

            //get company_id
            if (!$company_id && $paybill_number) {
                //get company_id from paybill_number
                //start get main paybill no
                $mpesa_paybill_data = getMainSingleCompanyPaybillData($paybill_number);
                $mpesa_paybill_data = json_decode($mpesa_paybill_data);
                $mpesa_paybill_data = $mpesa_paybill_data->data;

                $company_id = $mpesa_paybill_data->company_id;

                //dump($paybill_number, $company_id, $mpesa_paybill_data);
            }

            //get payment account data
            $account_data = Account::where('account_no', $account_no)
                                    ->where('company_id', $company_id)
                                    ->first();



            if (!$account_data) {
                //convert phone number to a fully qualified phone number
                try {
                    $account_no = getDatabasePhoneNumber($account_no);
                    $account_data = Account::where('phone', $account_no)
                                        ->where('company_id', $company_id)
                                        ->first();
                } catch(\Exception $e) {
                    $message = $e->getMessage() . ". Invalid account number.";
                    log_this($message);
                    throw new StoreResourceFailedException($message);
                }

            }

            //dd($account_data);

            //print_r(DB::getQueryLog());
            //if no account record exists, throw an error
            if (!$account_data) {
                //throw an error, account record does not exist
                //throw new StoreResourceFailedException('Non existent account!!! Please check the account_no');
                //$contact_phone = "0720743211";
                $message = "Wrong account number entered!!!";
                log_this($message);
                throw new StoreResourceFailedException($message);
            }

            $company_id = $account_data->company_id;
            $company_user_id = $account_data->company_user_id;
            $user_id = $account_data->user_id;
            $account_no = $account_data->account_no;

            //find deposit account no
            $deposit_account_data = DepositAccount::where('ref_account_no', $account_no)->first();
            if (!$deposit_account_data) {
                $message = "Deposit account does not exist!!!";
                log_this($message);
                throw new StoreResourceFailedException($message);
            }
            $deposit_account_no = $deposit_account_data->account_no;

            //user data
            $user_data = User::find($user_id);
            if (!$user_data) {
                $message = "User data does not exist!!!";
                log_this($message);
                throw new StoreResourceFailedException($message);
            }
            $user_id = $user_data->id;
            $first_name = titlecase($user_data->first_name);
            $last_name = titlecase($user_data->last_name);

            //dd($user_data);

            //company name
            $company_name = $account_data->company->name;
            $company_short_name = $account_data->company->short_name;

            //dd($company_name, $company_short_name, $company_id);

            //end check if account_no exists

            if ($account_data) {

                //set account no and other attributes
                $attributes['account_no'] = $deposit_account_no;
                $attributes['company_user_id'] = $company_user_id;
                $attributes['user_id'] = $user_id;

                //get company user data
                $company_user_data = CompanyUser::find($company_user_id);
                $registration_paid = $company_user_data->registration_paid;
                $registration_amount_paid = $company_user_data->registration_amount_paid;

                //dd($company_user_data);

                if (!$transfer) {
                    $tran_ref_txt = "mpesa_code - $mpesa_code - payment_name - $payment_name - payment_id - $payment_id";
                    $tran_desc = "Shares Deposit - company user - $company_user_id";
                }

                //store shares data
                try {

                    $attributes['tran_ref_txt'] = $tran_ref_txt;
                    $attributes['tran_desc'] = $tran_desc;
                    //dd($attributes);
                    //create a new shares entry
                    $shares_store = new SharesStore();

                    $new_shares = $shares_store->createItem($attributes);

                } catch(\Exception $e) {

                    DB::rollback();
                    $message = 'Error. Could not save new shares details - ' . $e->getMessage();
                    log_this($message);
                    throw new StoreResourceFailedException($message);
                    //return show_error($message);

                }

                //save payment to shares gl accounts
                try {

                    $shares_dep_gl_account_entry = createGlAccountEntry($payment_id, $amount, $shares_gl_account_type_id, 
                                                                        $company_id, $phone, "DR", $tran_ref_txt, $tran_desc, "neg", "neg", "pos");

                } catch(\Exception $e) {

                    DB::rollback();
                    dd($shares_gl_account_type_id, $e);
                    $message = 'Error. Could not create shares_dep_gl_account_entry - ' . $e->getMessage();
                    log_this($message);
                    throw new StoreResourceFailedException($message);

                }

            }


        DB::commit();

        $response['account'] = $account_data;
        $response['deposit_account'] = $deposit_account_data;
        $response['user'] = $user_data;
        $response['company_user'] = $company_user_data;
        $response['company'] = $company_user_data->company;

        return json_encode($response);

    }

}