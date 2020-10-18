<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\Status;
use App\User;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmailQueue extends Model
{

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'id', 'title', 'email_text', 'email_address', 'company_name', 'status_id', 'company_id', 'email_salutation',
         'has_attachments', 'event_type_id',
         'table_text', 'parent_id', 'reminder_message_id', 'panel_text', 'email_footer', 'subject', 'email_batch_id',
         'sent_at', 'created_at', 'updated_at', 'created_by', 'created_by_name', 'email_provider_name'
    ];

    protected $dates = ['sent_at'];

    /*start relationships*/
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function emailbatchdetails()
    {
        return $this->hasMany(EmailBatchDetail::class);
    }
    /*end relationships*/

    //start convert dates to local dates
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }

    public function getSentAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }
    //end convert dates to local dates

}
