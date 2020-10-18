<?php

namespace App\Entities;

use App\Entities\Company;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserLogin extends Model
{

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
        'id', 'name', 'email', 'phone', 'action', 'status', 'os', 'device', 'src_ip', 'user_agent', 'browser', 'browser_version'
    ];

    /*relationships*/
    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
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


    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {

        if ($attributes['status']!='locked') {
            //remove password
            unset($attributes['password']);
        } 

        if (array_key_exists('username', $attributes)) {
            if (validateEmail($attributes['username'])) {
                $attributes['email'] = $attributes['username'];
            } else {
                $attributes['phone'] = $attributes['username'];
            }
            //remove username
            unset($attributes['username']);
        }

        //add user env
        $agent = new \Jenssegers\Agent\Agent;

        $attributes['user_agent'] = serialize($agent);
        $attributes['browser'] = $agent->browser();
        $attributes['browser_version'] = $agent->version($agent->browser());
        $attributes['os'] = $agent->platform();
        $attributes['device'] = $agent->device();
        $attributes['src_ip'] = getIp();
        //end add user env

        //log_this(print_r("attributes - " . $attributes, true));

        //dd($attributes);

        $model = static::query()->create($attributes);

        return $model;

    }


}
