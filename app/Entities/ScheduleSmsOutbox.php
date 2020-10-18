<?php

namespace App\Entities;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ScheduleSmsOutbox extends Model
{
    
    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'message', 'short_message', 'phone_number', 'user_id', 'user_agent', 'src_ip', 'src_host', 'status_id', 'sms_type_id', 'created_by', 'updated_by'
    ];

    /*one to many relationship*/
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function smsoutbox()
    {
        return $this->hasOne(SmsOutbox::class);
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
    //end convert dates to local dates

}
