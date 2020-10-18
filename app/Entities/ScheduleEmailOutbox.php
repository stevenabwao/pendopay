<?php

namespace App\Entities;

use App\User;
use App\Entities\EmailOutbox;
use App\Entities\Status;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ScheduleEmailOutbox extends Model
{
    
    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'message', 'short_message', 'email', 'user_id', 'user_agent', 'src_ip', 'src_host', 'status_id', 
        'sms_type_id', 'created_by', 'updated_by'
    ];

    /*one to many relationship*/
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function emailoutbox()
    {
        return $this->hasOne(EmailOutbox::class);
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
