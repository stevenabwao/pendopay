<?php

namespace App\Entities;

use App\Entities\CompanyUser;
use App\Entities\Company;
use App\Entities\Image;
use App\Entities\Currency;
use App\Entities\Status;
use App\Entities\CommissionScale;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CommissionScaleAudit extends Model
{

    protected $table = 'commission_scale_audits';

    protected $dates = ['expiry_at', 'start_at', 'end_at'];
    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'id', 'parent_id', 'min', 'max', 'commission', 'status_id', 'created_by', 'updated_by'
    ];

    /*relationships*/
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function commissionscale()
    {
        return $this->belongsTo(CommissionScale::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
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

        if (auth()->user()) {
            $user_id = auth()->user()->id;

            $attributes['created_by'] = $user_id;
        }

        //add parent id
        $attributes['parent_id'] = $attributes['id'];

        //remove id and updated_by fields from array,
        //id will be auto populated (autoincrement field)
        unset($attributes['id']);

        $model = static::query()->create($attributes);

        return $model;

    }

}
