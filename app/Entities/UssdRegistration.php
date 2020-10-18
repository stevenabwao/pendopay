<?php

namespace App\Entities;

use App\Entities\Company;
use App\Events\UssdRegistrationCreated;
use App\Events\UssdRegistrationUpdated;
use App\User;
use App\Entities\UssdEvent;
use App\Entities\UssdPayment;
use App\Entities\UssdRegistrationArchive;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UssdRegistration extends Model
{
    
    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'name', 'phone', 'alternate_phone', 'tsc_no', 'ussd_event_id', 'company_id', 'email', 'phone_county', 'county', 'sub_county', 'workplace', 'ict_level', 'subjects', 'lipanampesacode', 'registered', 'time_stamp', 'user_agent', 'browser', 'browser_version', 'os', 'device', 'src_ip'
    ];


    /**
     * Fire events on the model, oncreated, onupdated
     */
    protected $events = [
        'created' => UssdRegistrationCreated::class,
        'updated' => UssdRegistrationUpdated::class,
    ];


    /*relationships*/
    public function company() {
        return $this->belongsTo(Company::class);
    }


    public function ussdevent() {
        return $this->belongsTo(UssdEvent::class, 'ussd_event_id', 'id');
    }


    public function ussdpayments() {
        return $this->hasMany(UssdPayment::class);
    }


    public function ussdregistrationarchives() {
        return $this->hasMany(UssdRegistrationArchive::class, 'id', 'parent_id');
    }


    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {

        $phone = $attributes['phone'];
        $tsc_no = $attributes['tsc_no'];
        $ussd_event_id = $attributes['ussd_event_id'];

        if (array_key_exists('phone', $attributes)) {
            $attributes['phone'] = getDatabasePhoneNumber($phone);
        }

        if (array_key_exists('alternate_phone', $attributes)) {
            $alternate_phone = $attributes['alternate_phone'];
            $attributes['alternate_phone'] = formatPhoneNumber($alternate_phone);
        }

        //add user env
        $agent = new \Jenssegers\Agent\Agent;

        $attributes['user_agent'] = serialize($agent);
        $attributes['browser'] = $agent->browser();
        $attributes['browser_version'] = $agent->version($agent->browser());
        $attributes['os'] = $agent->platform();
        $attributes['device'] = $agent->device();
        $attributes['src_ip'] = getIp();
        //end add user env

        $model = static::query()->create($attributes);

        //start check if successful and send sms to client
        if ($model) {
            
            $company_id = $model->ussdevent->company->id;
            $company_name = $model->ussdevent->company->name;
            $company_paybill_type = $model->ussdevent->company->paybill_type;
            $mpesa_till_data = $model->ussdevent->company
                               ->mpesapaybills;
            
            $mpesa_till_no = '';
            if ($company_paybill_type == 'paybill') {
                $mpesa_till_no = $mpesa_till_data
                               ->where('type', 'paybill')
                               ->first()->paybill_number;
            } else {
                $mpesa_till_no = $mpesa_till_data
                               ->where('type', 'till')
                               ->first()->till_number;
            }

            $sms_user_name = $model->ussdevent->company->sms_user_name;
            $name = $model->name;
            $phone = $model->phone;
            $event_cost = $model->ussdevent->amount;

            //send user message on success
            $message = "Dear $name, your registration request has been received by $company_name.";
            $message .= "Kindly send Kshs $event_cost to Mpesa Till no: $mpesa_till_no to complete your registration.";

            //start create new outbox
            createSmsOutbox($message, $phone, $company_id, $sms_user_name);
            //end create new outbox

        }
        //end check if successful and send sms to client

        return $model;

    }


    //start convert dates to local dates
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }


    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }
    //end convert dates to local dates


}
