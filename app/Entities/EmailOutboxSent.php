<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\SmsOutbox;
use App\User;
use App\Events\SmsOutboxCreated;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EmailOutboxSent extends Model
{
    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'id', 'parent_id', 'message', 'email', 'user_id', 'user_agent', 'src_ip', 
        'src_host', 'status_id', 'sms_type_id', 'company_id', 'delay', 
        'created_by', 'updated_by', 'created_at', 'updated_at'
    ];

    /**
     * Override default table
     */
    protected $table = "email_outboxes_sent";

    /*one to many relationship*/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent_message()
    {
        return $this->belongsTo(SmsOutbox::class);
    }

    /*one to many relationship*/
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /*one to many relationship*/
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /*one to one relationship*/
    public function scheduleSmsOutbox()
    {
        return $this->belongsTo(ScheduleSmsOutbox::class);
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
        //updated_by is not required
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
