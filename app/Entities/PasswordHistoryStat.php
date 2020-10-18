<?php

namespace App\Entities;

use App\Entities\Company;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PasswordHistory extends Model
{

    // table
    protected $table = 'password_history_stats';

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'id', 'company_id', 'email', 'username', 'userid', 'password', 
         'first_self_password_change', 'first_self_password_change_date', 'last_self_password_change_date', 
         'last_password_change_date', 'last_password_change_by', 'change_password_next_login', 'updated_at', 
         'updated_by', 'updated_by_name','created_at', 'created_by', 'created_by_name'
    ];

    /*start relationships*/
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
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
        
        if (auth()->user()) {
            $user_id = auth()->user()->id;
            $user_full_name = auth()->user()->first_name . " " . auth()->user()->last_name;
            $attributes['created_by'] = $user_id;
            $attributes['created_by_name'] = $user_full_name;
            $attributes['updated_by'] = $user_id;
            $attributes['updated_by_name'] = $user_full_name;
        }

        try {
            $model = static::query()->create($attributes);
        } catch(\Exception $e) {
            log_this($e->getMessage());
        }

        return $model;

    }

}
