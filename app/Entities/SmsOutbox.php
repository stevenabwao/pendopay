<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\CompanyUser;
//use App\Entities\SmsOutboxSent;
use App\User;
use App\Events\SmsOutboxCreated;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SmsOutbox extends Model
{
    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'message', 'phone_number', 'sms_user_name', 'user_id', 'company_user_id', 'user_agent', 'src_ip', 'src_host',
        'status_id', 'sms_type_id', 'company_id', 'schedule_sms_outbox_id', 'group_id', 'delay', 'created_by',
        'updated_by', 'created_at', 'updated_at'
    ];

    /**
     * Fire events on the model, oncreated, onupdated
     */
    /* protected $events = [
        'created' => SmsOutboxCreated::class
    ]; */

    /*one to many relationship*/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*public function sent_messages()
    {
        return $this->belongsTo(SmsOutboxSent::class);
    }*/

    /*one to many relationship*/
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function companyuser()
    {
        return $this->belongsTo(CompanyUser::class);
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

        $attributes['phone_number'] = getDatabasePhoneNumber($attributes['phone_number']);

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
