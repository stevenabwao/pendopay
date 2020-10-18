<?php

namespace App\Services\LoanApplication;

use App\Entities\LoanApplication;
use App\Entities\DepositAccount;
use App\Entities\Account;
use App\Entities\LoanProductSetting;
use App\Entities\LoanExposureLimit;
use App\Entities\LoanExposureLimitsDetail;
use App\Entities\LoanRepaymentSchedule;
use App\Entities\LoanAccount;
use App\Entities\DepositAccountSummary;
use App\Entities\CompanyUser;
use App\Entities\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Exception\UpdateResourceFailedException;

class LoanApplicationApproveRepost
{

    public function approveItem($id) {

        DB::beginTransaction();

        $message = array();

        //statuses
        $status_approved = config('constants.status.approved');
        $status_autoapproved = config('constants.status.autoapproved');
        $status_declined = config('constants.status.declined');
        $status_autodeclined = config('constants.status.autodeclined');
        $status_active = config('constants.status.active');
        $status_open = config('constants.status.open');
        $status_waiting = config('constants.status.waiting');

        //get the remote record and check res_code
        //res_code = 0 means the trans posted successfully
        //snb app name
        $snb_app_name = config('constants.settings.app_short_name');
        $result_decode = json_decode(getMpesaB2cRequestData($id, $snb_app_name));
        $result_decode = $result_decode->data;

        $res_code = $result_decode->res_code; 
        $orig_con_id = $result_decode->orig_con_id; 
        $processed = $result_decode->processed; 
        //dd($res_code, $orig_con_id, $processed);

        //if data was nt updated, attempt to update
        if (($res_code != 0) || ($processed != 1)) {
            //get main data - from b2c_outgoing_ack
            $result = getMpesaB2cRequestMainData($id, $snb_app_name);
            log_this("result - " . json_encode($result));
            //$result_decode = json_decode(json_encode($result));
            $result_decode = json_decode($result);
            log_this("result_decode - " . json_encode($result_decode));
            
            //dd($result_decode);

            //if result exists, proceed
            if (!isset($result_decode->error)) {
            //if (!$result_decode->error) {
                
                $result_decode = $result_decode->data;
                
                $res_code = $result_decode->res_code; 

                if ($res_code == 0) {

                    //resend the data if successful
                    $res_code = $result_decode->res_code;
                    $orig_con_id = $result_decode->orig_con_id;
                    $con_id = $result_decode->con_id;
                    $trans_id = $result_decode->trans_id;
                    $rx_fullname = $result_decode->rx_fullname;
                    $receiver = $result_decode->receiver;
                    $completed_time = $result_decode->completed_time;
                    $res_desc = $result_decode->res_desc;
                    $src_ip = $result_decode->src_ip;
                    $utility_bal = $result_decode->utility_bal;
                    $transStatus = "result";
                    //dd($rx_fullname);

                    $result_pm = resendB2CRequestToPendoadmin($id, $orig_con_id, $transStatus, $con_id, 
                        $trans_id, $rx_fullname, $receiver, $completed_time, $src_ip, 
                        $res_code, $res_desc, $utility_bal);

                    log_this("result_pm" . json_encode($result_pm));
                    // dd("hapa", $result_pm);
                    //get the mpesab2c data again, after update
                    $result_decode = json_decode(getMpesaB2cRequestData($id, $snb_app_name));
                    log_this("result_decode 2 " . json_encode($result_decode));
                    $result_decode = $result_decode->data;
                    //dd($result_decode);

                    $res_code = $result_decode->res_code; 
                    $orig_con_id = $result_decode->orig_con_id; 
                    $processed = $result_decode->processed;

                }

            } else {
                
                //no results, create a new entry
                //sendDataToMpesaB2c($shortcode, $phone, $amount, $tran_ref_txt, $company_id, $src_id, $app_name)

                //start activate/ approve loan application
                try {

                    $loan_application_approval = LoanApplication::find($id);

                    //get loan application details
                    $company_id = $loan_application_approval->company_id;
                    $approved_loan_amt = $loan_application_approval->loan_amt;
                    $user_phone = $loan_application_approval->companyuser->user->phone;
                    $loan_application_id = $loan_application_approval->id;

                    $loan_application_approval->status_id = $status_waiting;
                    $loan_application_approval->comments = "Waiting for Mpesa disbursement";

                    $loan_application_approval->save();

                } catch(\Exception $e) {

                    DB::rollback();
                    $message_text = "Error getting loan application details - " . $e->getMessage();
                    //dd($message_text);
                    log_this($message_text);
                    $show_message = "Error getting loan application details.";
                    //$message["message"] = $show_message;
                    //return show_json_error($message);
                    throw new StoreResourceFailedException($show_message);

                }
                //end activate/ approve loan application


                //start get company mpesa shortcode
                $mpesa_shortcode_data = getMainCompanyMpesaShortcode($company_id);
                log_this("mpesa_shortcode_data - " . json_encode($mpesa_shortcode_data));
                //dd($mpesa_shortcode_data);
                $mpesa_shortcode_data = json_decode($mpesa_shortcode_data);
                $mpesa_shortcode_data = $mpesa_shortcode_data->data;
                $shortcode_number = $mpesa_shortcode_data->shortcode_number;
                //end get company mpesa shortcode

                //dd($mpesa_shortcode_data);

                try {

                    //create mpesab2c request
                    $amount = $approved_loan_amt;
                    $phone = $user_phone;
                    $shortcode = $shortcode_number;
                    $tran_ref_txt = "Loan Application - " . $loan_application_id;
                    $src_id = $loan_application_id;
                    $app_name = "snb";
                    //sendDataToMpesaB2c($shortcode, $phone, $amount, $tran_ref_txt, $company_id, $src_id, $app_name);

                } catch(\Exception $e) {

                    DB::rollback();
                    $message_text = "Error creating mpesa b2c request - Loan Application - $id - " . $e->getMessage();
                    log_this($message_text);
                    $show_message = "Error processing loan. Please try again later.";
                    throw new StoreResourceFailedException($show_message);

                }

                $response["message"] = "Successful loan application. Please wait for it to be processed.";
                $response = show_json_success($response);

            }
        }

        $response = "";
        //dd($processed);

        if (($res_code == 0) && ($processed == 1)) {

            //mpesa successfully disbursed, resend message
            try {

                $loanApplicationUpdate = new LoanApplicationUpdate();
                //dd('tuko hapaa!!!');

                //update item
                $attributes['request_id'] = $id; 
                $attributes['trans_status'] = "completed";
                $result = $loanApplicationUpdate->updateItem($attributes);
                log_this("result loanApplicationUpdate " . json_encode($result));
                $result_message = json_decode($result);

                if ($result_message->error) {
                    throw new StoreResourceFailedException($result_message->message->message);
                } else {
                    $response = show_success($result_message->message);
                }
                
            } catch(\Exception $e) {
    
                DB::rollback();
                $show_message = "Could not update loan application:  $id -- ";
                $show_message .= " Company Product ID:  " . $e->getMessage();
                log_this($show_message . "<br> Loan Application Id -" . $id);
                throw new StoreResourceFailedException($show_message);
    
            }

        } else if (($res_code != 0) || ($processed != 1)) {

            //THIS SHUD ACTIVATE ON VERY RARE CASES
            //WHERE THE MONEY HAS BEEN DISBURSED VIA MPESA
            //BUT TE RECORD CUD NOT UPDATE b2c_outgoing_ack table
            //MAYBE DUE TO CONNECTIVITYY LAPSES AND ISSUES

            //confirm whether mpesa disb not successful
            //check in b2c_outgoing_ack table as a confirmation
            //if record exists, update mpesab2c_requests table with data and call LoanApplicationUpdate
            //else money has not been disbursed, repost the transaction again!!!

        } else {

            $show_message = "Could not update loan application:  $id -- ";
            $show_message .= " Company Product ID:  " . $e->getMessage();
            log_this($show_message . "<br> Loan Application Id -" . $id);
            $response = show_json_error($show_message . "<br> Loan Application Id -" . $id);
            //throw new StoreResourceFailedException($show_message);

        }
        

        DB::commit();

        return $response;

    }

}