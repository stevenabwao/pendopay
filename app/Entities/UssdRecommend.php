<?php

namespace App\Entities;

use App\Entities\Company;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UssdRecommend extends Model
{

    
    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
        'phone', 'full_name', 'rec_name', 'rec_phone', 'company_id', 'rec_date'
    ];


    // protected $events = [
    //     'created' => UssdRecommendCreated::class,
    // ]; 


    /*relationships*/
    public function company() {
        return $this->belongsTo(Company::class);
    }

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {

        if (auth()->user()) {
            $user_id = auth()->user()->id;

            $attributes['created_by'] = $user_id;
            $attributes['updated_by'] = $user_id;
        }

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
