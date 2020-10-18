<?php

namespace App\Entities;

use App\Entities\Company;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{

    // table
    protected $table = 'user_settings';

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'id', 'user_id', 'active_company_id', 'default_company_id', 'phone',
         'settings_type', 'target_id', 'dark_theme', 'color', 'mini_sidebar', 'updated_at', 
         'updated_by', 'updated_by_name','created_at', 'created_by', 'created_by_name'
    ];

    /*start relationships*/
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function activecompany()
    {
        return $this->belongsTo(Company::class, 'active_company_id', 'id');
    }

    public function defaultcompany()
    {
        return $this->belongsTo(Company::class, 'default_company_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
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

        $model = "";
        
        if (auth()->user()) {
            $user_data = auth()->user();
            $user_id = $user_data->id;
            $user_full_name = $user_data->first_name . " " . $user_data->last_name;
            $attributes['created_by'] = $user_id;
            $attributes['created_by_name'] = $user_full_name;
            $attributes['updated_by'] = $user_id;
            $attributes['updated_by_name'] = $user_full_name;
        }

        // dd("attributes *** ", $attributes);

        try {

            $model = static::query()->create($attributes);

        } catch(\Exception $e) {
            dd($e);
            log_this($e->getMessage());

        }

        return $model;

    }

}
