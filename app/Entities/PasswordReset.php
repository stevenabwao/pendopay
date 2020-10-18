<?php

namespace App\Entities;

use App\Entities\Company;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{

    // table
    protected $table = 'password_resets';

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'id', 'email', 'token', 'ip',  'status_id'
    ];

    /*start relationships*/
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

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }
    //end convert dates to local dates

    public static function create(array $attributes = [])
    {

        $attributes['ip'] = getIp();

        try {
            $model = static::query()->create($attributes);
        } catch(\Exception $e) {
            log_this($e->getMessage());
        }

        return $model;

    }

}
