<?php

namespace App\Entities;

use App\Entities\Company;
use App\User;
use App\Entities\UssdEvent;
use App\Entities\UssdPayment;
use App\Entities\UssdRegistration;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UssdRegistrationArchive extends Model
{

    
    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'parent_id', 'name', 'phone', 'alternate_phone', 'tsc_no', 'ussd_event_id', 'company_id', 'email', 'phone_county', 'county', 'sub_county', 'workplace', 'ict_level', 'subjects', 'lipanampesacode', 'registered', 'time_stamp', 'user_agent', 'browser', 'browser_version', 'os', 'device', 'src_ip'
    ];


    /*relationships*/
    public function company() {
        return $this->belongsTo(Company::class);
    }


    public function ussdevent() {
        return $this->belongsTo(UssdEvent::class);
    }


    public function ussdpayments() {
        return $this->hasMany(UssdPayment::class);
    }


    public function ussdregistration() {
        return $this->belongsTo(UssdRegistration::class, 'parent_id', 'id');
    }


    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {

        //add parent id
        $attributes['parent_id'] = $attributes['id'];

        //remove id and updated_by fields from array, 
        //id will be auto populated (autoincrement field)
        unset($attributes['id']);

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
