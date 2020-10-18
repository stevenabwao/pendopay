<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\UssdEvent;
use App\Entities\UssdPayment;
use App\Entities\UssdRegistration;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UssdPaymentDeposit extends Model
{
    
    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'ussd_payment_id', 'amount', 'mpesa_trans_id', 'phone', 'user_agent', 'browser', 'browser_version', 'os', 'device', 'src_ip'
    ];


    public function ussdevent() {
        return $this->belongsTo(UssdEvent::class, 'ussd_event_id', 'id');
    }


    public function ussdpayment() {
        return $this->belongsTo(UssdPayment::class, 'ussd_payment_id', 'id');
    }


    /**
      * @param array $attributes
      * @return \Illuminate\Database\Eloquent\Model
      */
    public static function create(array $attributes = [])
    {
 
         //add parent id
        $attributes['ussd_payment_id'] = $attributes['id'];

        //remove id and updated_by fields from array, 
        //id will be auto populated (autoincrement field)
        unset($attributes['id']);
        unset($attributes['ussd_event_id']);
 
         $model = static::query()->create($attributes);
  
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
