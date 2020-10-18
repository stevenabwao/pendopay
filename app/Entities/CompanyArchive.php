<?php

namespace App\Entities;

use App\Entities\Group;
use App\Entities\MpesaPaybill;
use App\Entities\SmsOutbox;
use App\User;
use App\Entities\UssdContactUs;
use App\Entities\UssdRecommend;
use App\Entities\UssdRegistration;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CompanyArchive extends Model
{
    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'parent_id', 'name', 'description', 'company_no', 'physical_address', 'ussd_code', 'box', 'paybill_type', 'sms_user_name', 'phone_number', 'email', 'latitude', 'longitude'
    ];

    protected $appends = ['groups'];

    /*one to many relationship*/
    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    /*one to many relationship*/
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /*one to many relationship*/
public function mpesapaybills()
    {
        return $this->hasMany(MpesaPaybill::class);
    }

    public function smsoutboxes()
    {
        return $this->hasMany(SmsOutbox::class);
    }

    public function ussdpayments()
    {
        return $this->hasManyThrough('App\UssdPayment', 'App\UssdEvent');
    }

    public function ussdregistrations() {
        return $this->hasMany(UssdRegistration::class);
    }

    public function ussdrecommends() {
        return $this->hasMany(UssdRecommend::class);
    }

    public function ussdcontactus() {
        return $this->hasMany(UssdContactUs::class);
    }

    public function getGroupsAttribute()
    {
        $groups = Group::where('company_id', $this->id)
                 ->get();
        return $groups;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
        //foreign key, local key
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
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

    public function getNameAttribute($value)
    {
        return strtoupper($value);
    }
    //end convert dates to local dates


}
