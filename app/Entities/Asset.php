<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\UssdEventMap;
use App\Entities\AssetType;
use App\Entities\Status;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{

    //use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'id', 'name', 'company_id', 'ussd_event_map_id', 'asset_type_id', 'mime',
         'short_url', 'status_id', 'created_at', 'created_by', 'updated_at', 'updated_by',
         'deleted_at', 'deleted_by'
    ];


    public function ussdeventmap()
    {
        return $this->belongsTo(UssdEventMap::class, 'ussd_event_map_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function assettype()
    {
        return $this->belongsTo(AssetType::class, 'asset_type_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'id', 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'id', 'updated_by');
    }


    //start convert dates to local dates
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }

    public function getDeletedAtAttribute($value)
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

        if (auth()->user()) {
            $user_id = auth()->user()->id;

            $attributes['created_by'] = $user_id;
            $attributes['updated_by'] = $user_id;
        }

        $model = static::query()->create($attributes);

        return $model;

    }

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function updatedata($id, array $attributes = [])
    {

        if (auth()->user()) {
            $user_id = auth()->user()->id;

            $attributes['updated_by'] = $user_id;
        }

        //item data
        $item = static::query()->findOrFail($id);

        //do any extra processing here

        $model = $item->update($attributes);

        return $model;

    }


}
