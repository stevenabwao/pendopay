<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\Status;
use App\Entities\EmailBatch;
use App\Entities\EmailQueue;
use App\User;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmailBatchDetail extends Model
{
    
    protected $table = "email_batch_details";

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'id', 'email_batch_id', 'email_queue_id', 'status_id'
    ];

    /*start relationships*/
    public function emailbatch()
    {
        return $this->belongsTo(EmailBatch::class, 'email_batch_id', 'id');
    }

    public function emailqueue()
    {
        return $this->belongsTo(EmailQueue::class, 'email_queue_id', 'id');
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
