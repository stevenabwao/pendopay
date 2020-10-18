<?php

namespace App\Http\Controllers\Api\Sms;

use App\Entities\SmsAccount;
use App\Entities\SmsInbox;
use App\Entities\SmsOutbox;
use App\Entities\SmsPendoMessage;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Transformers\Sms\SmsAccountTransformer;
use Carbon\Carbon;
use Dingo\Api\Exception\ResourceException;
use Dingo\Api\Http\Response\paginator;
use Illuminate\Database\Eloquent\paginate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SmsAccountController extends BaseController
{
 
    //Display sms account details listing 
    public function getBulkSmsAccounts(Request $request)
    {

        //get url params
        $username = $request->get('username');
        $paybill = $request->get('paybill');
        $id = $request->get('id');

        $smsAccounts = new SmsAccount();
        
        //filter results
        if ($username != null) { $smsAccounts = $smsAccounts->where('username', "$username"); }
        if ($paybill) { $smsAccounts = $smsAccounts->where('paybill', "$paybill"); }
        if ($id) { $smsAccounts = $smsAccounts->where('id', "$id"); }

        $smsAccounts = $smsAccounts->paginate($request->get('limit', config('app.pagination_limit')));
        
        return $this->response->paginator($smsAccounts, new SmsAccountTransformer());

    }

    //get a single sms account details
    public function getBulkSmsAccount(Request $request)
    {

        //get url params
        $username = $request->get('username');

        $smsAccount = SmsAccount::where('username', $username)->first();
        return $this->response->item($smsAccount, new SmsAccountTransformer());
            
    }

    //Send bulk sms 
    public function sendBulkSms(Request $request)
    {

        //get url params
        $usr = $request->get('usr');
        $pass = $request->get('pass');
        $dest = $request->get('dest');
        $msg = $request->get('msg');

        //constants
        $min_bal = config('constants.settings.min_bal');
        $sms_destination_number = config('constants.settings.sms_destination_number');
        $config_default_source = config('constants.settings.default_source');
        $config_default_sid = config('constants.settings.default_sid');
        $gw_usr = config('constants.settings.gw_usr');
        $gw_pass = config('constants.settings.gw_pass');
        $gw_from = config('constants.settings.gw_from');
        $gw_smscid = config('constants.settings.gw_smscid');
        $sdp_pass = config('constants.settings.sdp_pass');
        $gw_smscid = config('constants.settings.gw_smscid');

        //messages
        $no_authorization_msg = config('constants.error_messages.no_authorization');
        $insufficient_balance_msg = config('constants.error_messages.insufficient_balance');
        $insufficient_data_msg = config('constants.error_messages.insufficient_data');
        $invalid_phone_number_msg = config('constants.error_messages.invalid_phone_number');

        $message_sent = config('constants.success_messages.message_sent');

        //check data
        $rules = [
            'usr' => ['required'],
            'pass' => ['required'],
            'dest' => ['required'],
            'msg' => ['required']
        ];

        $payload = app('request')->only('usr', 'pass', 'dest', 'msg');

        $validator = app('validator')->make($payload, $rules);

        if ($validator->fails()) {
            throw new ResourceException($validator->errors());
        }

        if ($dest) {
            if (!isValidPhoneNumber($dest)){
                throw new ResourceException($invalid_phone_number_msg);
            }
        }

        //do we have all required data?
        if ($usr && $pass) {
            
            //get bulk sms data
            $bulk_sms_data_array = SmsAccount::where('username', $usr)
                                    ->where('passwd', $pass)
                                    ->first();
            $grp= trim($bulk_sms_data_array['rights']);
            $bal = intval($bulk_sms_data_array['sms_balance']);
            $default_source = $bulk_sms_data_array['default_source'];
            $default_sid = $bulk_sms_data_array['default_sid'];
            $error = $bulk_sms_data_array['error'];

            //are we ok?
            if ($error) {
                
                throw new ResourceException($no_authorization_msg, $validator->errors());
             
            } else if ($bal < $min_bal) {
        
                //insufficient sms balance
                throw new ResourceException($insufficient_balance_msg);
             
            } else if (!$dest || !$msg) {
                    
                //missing data
                throw new ResourceException($insufficient_data_msg);
                 
            } else if (!isValidPhoneNumber($dest)) {
                    
                //missing data
                throw new ResourceException($invalid_phone_number_msg);
                 
            } else {
               
                $dest = formatPhoneNumber($dest);
                $src_ip = getIp();

                //*************************** get sms user data *****************************************//
                if ($default_sid && $default_source){
                    
                    $source = $default_source;
                    $sid = $default_sid;
    
                } else {
                    
                    //default
                    $source = $config_default_source;
                    $sid = $config_default_sid;
                    
                }
                //*************************** end get sms user data ************************************//

                //create/ send new sms
                $msg = urlencode($msg);
                $send_url=sprintf("http://192.168.5.211/sdp/send_sms.php?source=". $source ."&dest=%s&sid=". $sid ."&spid=601395&sp_passwd=$sdp_pass&cat=GIZ123&ret=0&msg=%s", $dest, $msg);
                          
                log_sms_this("SEND URL:\n$send_url");
                $sub_resp = callurl($send_url);
                log_sms_this("SEND_RESP:\n$sub_resp");
                log_sms_this($send_url);
                
                //*************************** save sent sms  *****************************************//
                $smsPendoMessage = new SmsPendoMessage();
                $smsPendoMessage->message = $msg;
                $smsPendoMessage->time_stamp = Carbon::now();
                $smsPendoMessage->sender = $usr;
                $smsPendoMessage->host = $src_ip;
                $smsPendoMessage->save();
                //*************************** end save sent sms  ************************************//

                //*************************** save to sms_gw_sms  ***********************************//
                $smsOutbox = new SmsOutbox();
                $smsOutbox->date_created = Carbon::now();
                $smsOutbox->originator = $gw_from;
                $smsOutbox->destination = $dest;
                $smsOutbox->message = $msg;
                $smsOutbox->smscid = $gw_smscid;
                $smsOutbox->username = $usr;
                $smsOutbox->save();
                //*************************** end save to sms_gw_sms  ********************************//

                //get count of msgs in sent sms
                $sms_count = ceil(strlen($msg)/160);

                //get user's sms account balance
                $data = SmsAccount::where('username', $usr)->first();
                $sms_balance = $data->sms_balance;
                $new_balance = $sms_balance - $sms_count;

                //update user's sms account balance
                $smsAccount = SmsAccount::where('username', $usr)->first();
                $smsAccount->sms_balance = $new_balance;
                $smsAccount->save();
                                            
            }

        }
                
        return success_message($message_sent);

    }


    //Display sms inbox listing 
    public function smsInbox(Request $request)
    {

        //get url params
        $username = $request->get('username');
        $source = $request->get('source');
        $search_text = explode(' ', $request->get('search_text'));
        $id = $request->get('id');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');

        $smsInbox = new SmsInbox();
        
        //filter results
        if ($username) { $smsInbox = $smsInbox->where('msg_text', 'like', "%$username%"); }
        if ($search_text) { $smsInbox = $smsInbox->whereIn('msg_text', "$search_text"); }
        if ($id) { $smsInbox = $smsInbox->where('que_id', "$id"); }
        if ($start_date) { $smsInbox = $smsInbox->where('que_date', '>=', "$start_date"); }
        if ($end_date) { $smsInbox = $smsInbox->where('que_date', '<=', "$end_date"); }   

        $smsInbox = $smsInbox->where('dest', config('constants.settings.sms_destination_number')); 
        $smsInbox = $smsInbox->paginate($request->get('limit', config('app.pagination_limit')));
                
        return $this->response->paginator($smsInbox, new SmsInboxTransformer());

    }


}
