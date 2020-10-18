<?php
namespace App\Services\Sms;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SmsOutboxStore 
{

    public function createItem($data) {

    	//get data object
        $bulk_sms_data = getCompanyBulkSMSData($data->company_id);
        //dd($bulk_sms_data);
            
        //send sms
        $params['usr'] = $bulk_sms_data['sms_user_name'];
        $params['src'] = $bulk_sms_data['default_source'];
        $params['pass'] = $bulk_sms_data['passwd'];
        $params['phone_number'] = $data->phone_number;
        $params['sms_message'] = $data->message;

        //send sms
        $response = sendSms($params);

        //Log::info('Sent SMS: '.$params);

        return $response;

	}

}