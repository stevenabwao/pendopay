<?php

namespace App\Entities;

use App\Entities\Status;
use App\Entities\UssdEvent;
use App\Entities\UssdEventMap;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;


class UssdEventType extends Model
{

    //use SoftDeletes; 

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
        'id', 'name', 'status_id', 'created_by', 'updated_by', 'deleted_by'
    ];
    

    /**
     * The attributes that should be mutated to dates. 
     *
     * @var array
    */
    protected $dates = ['deleted_at'];


    /*relationships*/
    public function ussdevents() {
        return $this->hasMany(UssdEvent::class);
    }

    public function ussdeventmaps() {
        return $this->hasMany(UssdEventMap::class, 'id', 'ussd_event_type_id');
    }


    public function status() {
        return $this->belongsTo(Status::class);
    }
    

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {

        $model = static::query()->create($attributes);

        return $model;

    }

    public function getDeletedAtAttribute($value)
    {
        return Carbon::parse($value);
    }

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
