<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\EmailOutboxSent;
use App\Entities\ScheduleEmailOutbox;
use App\User;
use App\Events\EmailOutboxCreated;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EmailOutbox extends Model
{

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'message', 'email', 'user_id', 'user_agent', 'src_ip', 'src_host', 'status_id', 
        'sms_type_id', 'company_id', 'schedule_sms_outbox_id', 'group_id', 'delay', 'created_by', 'updated_by', 
        'created_at', 'updated_at'
    ];

    /**
     * Fire events on the model, oncreated, onupdated
     */
    protected $events = [
        'created' => EmailOutboxCreated::class
    ];


    /**
     * Override default table
     */
    protected $table = "email_outboxes";


    /*start relationships*/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sent_messages()
    {
        return $this->belongsTo(EmailOutboxSent::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function scheduleEmailOutbox()
    {
        return $this->belongsTo(ScheduleEmailOutbox::class);
    }
    /*end relationships*/


    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {

        $attributes['phone_number'] = getDatabasePhoneNumber($attributes['phone_number']);
        //$attributes['short_message'] = reducelength($attributes['message'],45);
        
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
