<?php

namespace App\Entities;

use App\BaseModel;
use App\Entities\Status;
use App\Entities\CommissionScaleAudit;
use App\User;

class CommissionScale extends BaseModel
{

    protected $table = 'commission_scale';

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'id', 'min', 'max', 'commission', 'company_id', 'status_id', 'created_by', 'updated_by'
    ];

    /*relationships*/
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function commissionscaleaudits()
    {
        return $this->hasMany(CommissionScaleAudit::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
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

        $model = $item->update($attributes);

        return $model;

    }

}
