<?php

namespace App\Entities;

use App\Entities\Status;
use App\Entities\UssdEvent;
use App\Entities\Asset;
use App\Entities\Company;
use App\Entities\UssdEventType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;


class UssdEventMap extends Model
{

    //use SoftDeletes;

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
        'id', 'name', 'ussd_event_id', 'company_id', 'ussd_event_type_id', 'required', 'status_id', 'created_by', 'updated_by'
    ];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
    */
    //protected $dates = ['deleted_at'];


    /*relationships*/
    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function ussdevent() {
        return $this->belongsTo(UssdEvent::class, 'id', 'ussd_event_map_id');
    }

    public function assets() {
        return $this->hasMAny(Asset::class, 'id', 'ussd_event_map_id');
    }

    public function ussdeventtype() {
        return $this->belongsTo(UssdEventType::class, 'ussd_event_type_id', 'id');
    }


    public function status() {
        return $this->belongsTo(Status::class, 'status_id', 'id');
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

    // public function getDeletedAtAttribute($value)
    // {
    //     return Carbon::parse($value);
    // }

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
