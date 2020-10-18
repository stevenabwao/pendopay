<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\Status;
use App\User;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmailProviderSetting extends Model
{

    protected $table = "email_provider_settings";

    /**
     * The attributes that are mass assignable 
    **/
    protected $fillable = [
         'id', 'day_limit', 'email_provider_name', 'created_by', 'updated_by', 'updated_at', 'created_at'
    ];

    /*start relationships*/
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function emailprovider()
    {
        return $this->belongsTo(EmailProvider::class, 'email_provider_name', 'name');
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
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
