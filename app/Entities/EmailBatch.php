<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\Status;
use App\User;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmailBatch extends Model
{


    protected $table = "email_batches";

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'id', 'number_emails', 'email_provider_name', 'created_by', 'created_by_name', 'sent_at', 'created_at'
    ];

    protected $dates = ['sent_at'];

    /*start relationships*/
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

    public function getSentAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }
    //end convert dates to local dates


}
