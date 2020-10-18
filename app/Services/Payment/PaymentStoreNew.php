<?php

namespace App\Services\Payment;

use App\Entities\Account;
use App\Entities\Company;
use App\Entities\CompanyUser;
use App\Entities\Payment;
use App\Entities\PaymentDeposit;
use App\Entities\DepositAccount;
use App\Entities\LoanAccount;
use App\Mail\NewUserPayment;
use App\Services\Deposit\DepositStore;
use App\Services\User\CreateUserAccount;
use App\Services\Payment\PaymentDepositStore;
use App\Services\LoanRepayment\LoanRepaymentStore;
use App\User;
use Carbon\Carbon;
use Mail;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentStoreNew
{

    use Helpers;

    public function createItem($attributes) {

        //DB::enableQueryLog();

        $repost = false;
        $date = Carbon::now();
        $date = $date->toDateTimeString();

        //dd($attributes);

        //is this a repost? a repost will have an id attribute
        if (array_key_exists('id', $attributes)) {

            $repost = true;

            $payment_id = $attributes['id'];
            //get existing payment data
            $payment_result = Payment::find($payment_id);
            //dd($attributes, $payment_result);

            $amount =  $payment_result->amount;
            $full_name =  $payment_result->full_name;
            $phone_number =  $payment_result->phone;
            $paybill_number =  $payment_result->paybill_number;
            $account_no =  $payment_result->account_no;
            $trans_id =  $payment_result->trans_id;
            $src_ip =  $payment_result->src_ip;

            //update payment
            $payment_update = $payment_result->update($attributes);
            //end update payment

            //reset the attributes
            $attributes['amount'] = $amount;
            $attributes['full_name'] = $full_name;
            $attributes['phone'] = $phone_number;
            $attributes['paybill_number'] = $paybill_number;
            $attributes['account_no'] = $account_no;
            $attributes['trans_id'] = $trans_id;
            $attributes['src_ip'] = $src_ip;
            //dd($attributes, $payment_result);

        } else {

            //get sent data
            $amount =  $attributes['amount'];
            $full_name =  $attributes['full_name'];
            $phone_number =  $attributes['phone'];
            $paybill_number =  $attributes['paybill_number'];
            $account_no =  $attributes['account_no'];
            $top_account_no =  $account_no;
            $trans_id =  $attributes['trans_id'];
            //attach attributes
            $attributes['created_by_name'] = 'pendom';
            $attributes['updated_by_name'] = 'pendom';

            //create new payment
            $payment = new Payment();
            $payment_result = $payment->create($attributes);
            $payment_id = $payment_result->id;
            //end create payment

        }

        //get company_id
        if ($paybill_number) {

            try {

                //get company_details from paybill_number
                //$mpesa_paybill_data = getMainCompanyPaybillData('', $paybill_number);
                $mpesa_paybill_data = getMainSingleCompanyPaybillData($paybill_number);
                $mpesa_paybill_data = json_decode($mpesa_paybill_data);
                //dump($mpesa_paybill_data);
                $paybill_company_data = $mpesa_paybill_data->data->company->data;
                //dd($paybill_company_data);
                $company_id = $paybill_company_data->id;
                $company_name = $paybill_company_data->name;
                $company_short_name = $paybill_company_data->short_name;
                //dd($company_short_name);
                // $company_phone = $paybill_company_data->phone;
                // $company_ussd_code = $paybill_company_data->ussd_code;
                // $company_website = $paybill_company_data->website;

                //update company id and name
                $payment_update = Payment::find($payment_id)
                        ->update([
                            'company_id' => $company_id,
                            'company_name' => $company_name
                        ]);

            } catch (\Exception $e) {

                dd($e);
                $show_message = $e->getMessage();
                //dd($show_message);
                dd($e);
                log_this($show_message);
                $message["message"] = $show_message;
                return show_json_error($message);

            }

        }


        //start transaction
        DB::beginTransaction();

            //snb constants
            $snb_helpline = config('constants.snb_settings.helpline');
            $snb_website = config('constants.snb_settings.website');
            $snb_company_name = config('constants.snb_settings.company_name');
            $sms_type_id = config('constants.sms_types.company_sms');

            //get company data using paybill number
            //if company is non exisent, use snb data
            $company_name = $snb_company_name;
            $company_short_name = $snb_company_name;
            $company_phone = $snb_helpline;
            $company_website = $snb_website;
            $company_id = "";

            //get company_id
            if ($paybill_number && (!$company_id)) {

                //get company_details from paybill_number
                //$mpesa_paybill_data = getMainCompanyPaybillData('', $paybill_number);
                $mpesa_paybill_data = getMainSingleCompanyPaybillData($paybill_number);
                $mpesa_paybill_data = json_decode($mpesa_paybill_data);
                //dump($mpesa_paybill_data);
                $paybill_company_data = $mpesa_paybill_data->data->company->data;
                //dd($paybill_company_data);
                $company_id = $paybill_company_data->id;
                $company_name = $paybill_company_data->name;
                $company_short_name = $paybill_company_data->short_name;
                //dd($company_short_name);
                $company_phone = $paybill_company_data->phone;
                $company_ussd_code = $paybill_company_data->ussd_code;
                $company_website = $paybill_company_data->website;

                //update company id and name
                $payment_update = Payment::find($payment_id)
                        ->update([
                            'company_id' => $company_id,
                            'company_name' => $company_name
                        ]);

            }

            ////////////////////////////////////
            $repayment_amount = 0;

            //get companyuserid
            //if no account_no is entered, use the senders phone number as account_no
            $phone_account_no = $phone_number;

            //if account_no is entered, use the submitted account_no/ phone
            if ($account_no){
                try{
                    $phone_account_no = getDatabasePhoneNumber($account_no);
                } catch (\Exception $e) {
                    dd($e);
                    DB::rollback();
                    dd($e);
                    $show_message = "Invalid account number";
                    log_this($show_message);
                    $message["message"] = $show_message;

                    $payment_update = Payment::find($payment_id)
                        ->update([
                            'fail_reason' => $show_message,
                            'failed' => '1',
                            'failed_at' => $date
                        ]);

                    return show_json_error($message);
                }
            }

            //$account_data = getCompanyUserData($company_id, $phone_number);
            $account_data = getCompanyUserData($company_id, $phone_account_no);

            //dd($account_data);

            //if account exists, check loans balances
            if ($account_data) {

                $company_user_id = $account_data->id;

                //check if user has active loan in company
                $status_open = config('constants.status.open');
                $status_unpaid = config('constants.status.unpaid');

                $user_loan_data = LoanAccount::where('company_user_id', $company_user_id)
                                            ->where('company_id', $company_id)
                                            ->where(function($q) use ($status_open, $status_unpaid){
                                                $q->where('status_id', '=', $status_open);
                                                $q->orWhere('status_id', '=', $status_unpaid);
                                            })
                                            ->first();
                //dd($user_loan_data);

                //if user has balance, repay here
                if ($user_loan_data) {

                    $loan_bal = $user_loan_data->loan_bal_calc;
                    $loan_account_id = $user_loan_data->id;

                    //if payment is more than loan_bal, save the extra into user deposit account
                    if ($amount > $loan_bal) {

                        //save extras
                        $repayment_amount = $loan_bal;

                        //set new amount
                        $deposit_amount = $amount - $loan_bal;

                    } else {

                        $repayment_amount = $amount;

                    }

                } else {

                    $deposit_amount = $amount;
                    
                }

            }
            ///////////////////////////////////

            //dd($amount, $deposit_amount, $repayment_amount);


            //if amount balance exists, proceed
            if ($deposit_amount > 0) {

                //start create new payment deposit item
                try{

                    $paymentDepositStore = new PaymentDepositStore();

                    //dd($payment_id, $attributes);

                    $payment_deposit_result = $paymentDepositStore->createItem($payment_id, $attributes);
                    //dd(json_decode($payment_deposit_result));
                    log_this("\n\n\n************** PAYMENT STORE ************* \n\n"
                    . json_encode($payment_deposit_result)
                    . "\n\n*******************************************\n\n");

                    //update payment record
                    $payment_deposit_result = json_decode($payment_deposit_result);

                    $company = $payment_deposit_result->company;
                    $account = $payment_deposit_result->account;
                    $company_user = $payment_deposit_result->company_user;
                    $company_id = $company->id;
                    $company_name = $company->name;
                    $company_short_name = $company->short_name;
                    $company_phone = $company->phone;
                    $account_no = $account->account_no;
                    $account_name = $account->account_name;
                    $company_user_id = $company_user->id;

                } catch (\Exception $e) {
                    
                    dd($e);
                    DB::rollback();
                    $error_message = $e->getMessage();
                    dd($e);

                    $payment_update = Payment::find($payment_id)
                        ->update([
                            'fail_reason' => $error_message,
                            'failed' => '1',
                            'failed_at' => $date
                        ]);
                }

                //update record
                //get payment record
                try {

                    $payment_update = Payment::find($payment_id)
                        ->update([
                            'company_id' => $company_id,
                            'company_name' => $company_name,
                            'account_no' => $account_no,
                            'account_name' => $account_name,
                            'processed' => '1',
                            'processed_at' => $date
                        ]);
                    //dd($payment_update, $payment_id);
                    //end update payment record

                    //start save payment deposit record
                    $amount = $payment_result->amount;
                    $currency_id = $payment_result->currency_id;
                    $payment_method_id = $payment_result->payment_method_id;
                    $paybill_number = $payment_result->paybill_number;
                    $phone = $payment_result->phone;
                    $full_name = $payment_result->full_name;
                    $trans_id = $payment_result->trans_id;
                    $src_ip = $payment_result->src_ip;
                    $trans_time = $payment_result->trans_time;
                    //$date_stamp = $payment_result->date_stamp;
                    $comments = $payment_result->comments;
                    $modified = $payment_result->modified;
                    $reposted_at = $date;
                    $reposted_by = $payment_result->reposted_by;
                    $created_by = $payment_result->created_by;
                    $updated_by = $payment_result->updated_by;

                } catch (\Exception $e) {
                    
                    dd($e);
                    DB::rollback();
                    dd($e);
                    $error_message = $e->getMessage();

                    $payment_update = Payment::find($payment_id)
                        ->update([
                            'fail_reason' => $error_message,
                            'failed' => '1',
                            'failed_at' => $date
                        ]);

                }


                try {

                    $new_payment_deposit = new PaymentDeposit();

                        $payment_deposit_attributes['payment_id'] = $payment_id;
                        $payment_deposit_attributes['company_id'] = $company_id;
                        $payment_deposit_attributes['company_name'] = $company_name;
                        $payment_deposit_attributes['account_no'] = $account_no;
                        $payment_deposit_attributes['account_name'] = $account_name;
                        $payment_deposit_attributes['processed'] = "1";
                        $payment_deposit_attributes['processed_at'] = $date;
                        $payment_deposit_attributes['amount'] = $amount;
                        $payment_deposit_attributes['currency_id'] = $currency_id;
                        $payment_deposit_attributes['payment_method_id'] = $payment_method_id;
                        $payment_deposit_attributes['paybill_number'] = $paybill_number;
                        $payment_deposit_attributes['phone'] = $phone;
                        $payment_deposit_attributes['full_name'] = $full_name;
                        $payment_deposit_attributes['trans_id'] = $trans_id;
                        $payment_deposit_attributes['src_ip'] = $src_ip;
                        $payment_deposit_attributes['trans_time'] = $trans_time;
                        //$payment_deposit_attributes['date_stamp'] = $date_stamp;
                        $payment_deposit_attributes['modified'] = $modified;
                        $payment_deposit_attributes['reposted_at'] = $date;
                        $payment_deposit_attributes['reposted_by'] = $reposted_by;

                        //dd($payment_deposit_attributes);

                    $payment_deposit = $new_payment_deposit->create($payment_deposit_attributes);

                    //dd($payment_deposit, $payment_deposit_result);

                    
                    //dd($attributes);
                } catch (\Exception $e) {
                    
                    dd($e);
                    DB::rollback();
                    //dd($e);
                    $error_message = $e->getMessage();

                    $payment_update = Payment::find($payment_id)
                        ->update([
                            'fail_reason' => $error_message,
                            'failed' => '1',
                            'failed_at' => $date
                        ]);

                }


                //start send success sms message
                try {

                    if ($company_phone) {
                        $snb_helpline = $company_phone;
                    }

                    if ($company_short_name) {
                        $company_name = $company_short_name;
                    } else {
                        $company_name = $snb_company_name;
                    }

                    $amount_fmt = formatCurrency($amount);
                    $message = sprintf("Dear %s, your payment of %s to account: %s has been successful. Thank you for using %s. Helpline: %s", $full_name, $amount_fmt, $account_name, $company_name, $snb_helpline);

                    //dd($message);
                    //TODO
                    //$result = createSmsOutbox($message, $phone_number, $sms_type_id, $company_id, $company_user_id);
                    //end send success sms message

                    //start send account owner email on transaction
                    //get payment record
                    $payment = Payment::find($payment_id);
                    //dd($payment->account->companyuser->user);
                    //find account owner email
                    if ($payment->account) {
                        if ($payment->account->companyuser) {
                            if ($payment->account->companyuser->user) {
                                $email = $payment->account->companyuser->user->email;
                                if ($email) {
                                    //Mail::to($email)
                                    //    ->send(new NewUserPayment($payment));

                                    //////
                                    $first_name = $payment->account->companyuser->user->first_name;
                                    $company_name = $payment->account->companyuser->company->name;
                                    $company_id = $payment->account->companyuser->company->id;
                                    $local_phone = $payment->account->companyuser->user->phone;
                                    $phone_country = $payment->account->companyuser->user->phone_country;
                                    $user_phone = getDatabasePhoneNumber($local_phone, $phone_country);
                                    $localised_phone = getLocalisedPhoneNumber($local_phone, $phone_country);

                                    $company_short_name = $payment->account->companyuser->company->short_name;
                                    if (!$company_short_name) {
                                        $company_short_name = $company_name;
                                    }

                                    //start get main paybill no
                                    $mpesa_paybill = $payment->paybill_number;
                                    //end get main paybill no

                                    $amount_fmt = formatCurrency($payment->amount);

                                    //start send email to queue
                                    $subject = 'Dear ' . ucfirst($first_name) . ', Successful Deposit to your Account at  ' . $company_short_name;
                                    $title = $subject;

                                    $email_salutation = "Dear " . $first_name . ",<br><br>";

                                    $email_text = "Deposit of <strong>$amount_fmt</strong> has been made to your account at $company_name.<br><br>";
                                    $email_text .= "Payment details are as follows: <br><br>";

                                    $panel_text = "Sender Full Name: <strong>" . $payment->full_name . "</strong><br><br>";
                                    $panel_text .= "Sender Phone: <strong>" . $payment->phone . "</strong><br><br>";
                                    $panel_text .= "Your Account Name: <strong>" . $payment->account_name . "</strong><br><br>";
                                    $panel_text .= "Amount: <strong>" . $amount_fmt . "</strong><br>";

                                    $email_footer = "Regards,<br>";
                                    $email_footer .= "$company_short_name Management";
                                    
                                    $table_text = "";

                                    $parent_id = 0;
                                    $reminder_message_id = 0;

                                    // dd($email_text, $panel_text);
                                    
                                    $result = sendTheEmailToQueue($email, $subject, $title, $company_name, $email_text, $email_salutation, 
                                                                $company_id, $email_footer, $panel_text, $table_text, $parent_id);
                                    //end send email to queue


                                }
                            }
                        }
                    }
                    //end send account owner email on transaction

                    //dd($payment_deposit_result);

                    $result_data = show_json_success($payment_deposit_result);

                } catch(\Exception $e) {

                    dd($e);
                    DB::rollback();
                    $error_message = $e->getMessage();
                    dd($e);

                    $payment_update = Payment::find($payment_id)
                        ->update([
                            'fail_reason' => $error_message,
                            'failed' => '1',
                            'failed_at' => $date
                        ]);

                        //dd($e->getMessage());

                    //if trans is not being reposted by admin, show error msg
                    if (!$repost) {

                        //if not reposting, send error message to user
                        //start create sms message
                        $message = "Dear $full_name, the account you have entered: $top_account_no cannot be found. ";
                        $message .= "Please call: $company_phone ";
                        $message .= " or dial *533# and choose help";
                        if ($company_website) { $message .= " or visit $company_website"; } //show if company has a website
                        $message .= ". Thank you. $company_short_name Team.";
                        //end create sms message

                        $params['sms_message']      = $message;
                        $params['phone_number']     = $phone_number;
                        $params['company_id']     = $company_id;

                        //send sms
                        $response = sendApiSms($params);
                        //end send  sms message

                    }

                    return show_json_error($error_message);

                }
                //end create new payment deposit item

            }

            //dd($amount, $repayment_amount, $result_data);


            //if repayment amount exists, save loan repayment
            if ($repayment_amount > 0) {

                try {

                    //create repayment entry here
                    $loanRepaymentStore = new LoanRepaymentStore();

                    $repay_attributes['company_user_id'] = $company_user_id;
                    $repay_attributes['company_id'] = $company_id;
                    $repay_attributes['phone'] = $phone_number;
                    $repay_attributes['amount'] = $repayment_amount;
                    $repay_attributes['mpesa_code'] = $trans_id;
                    $repay_attributes['payment_id'] = $payment_id;
                    $repay_attributes['payment_name'] = $full_name;

                    $loan_repayment_result = $loanRepaymentStore->createItem($repay_attributes);
                    log_this("\n\n\n************** PAYMENT STORE ************* \n\n"
                    . json_encode($loan_repayment_result)
                    . "\n\n*******************************************\n\n");

                } catch(\Exception $e) {

                    dd($e);
                    DB::rollback();
                    $show_message = $e->getMessage();
                    //dd($show_message);
                    dd($e);
                    log_this($show_message);
                    $message["message"] = $show_message;
                    return show_json_error($message);

                }

            }

        DB::commit();

        //dd(DB::getQueryLog());

        //dd(json_decode($result_data));

        return $result_data;

    }

}
