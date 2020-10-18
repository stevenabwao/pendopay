<?php

namespace App\Entities;

use App\Entities\CompanyUser;
use App\Entities\Company;
use App\Entities\Category;
use App\Entities\Image;
use App\Entities\Status;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class OrderAudit extends Model
{

    protected $dates = ['confirmed_at', 'rejected_at', 'submitted_at', 'delivered_at',
                        'paid_at'];
    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'id', 'parent_id', 'name', 'total', 'club_total', 'commission',  'currency_id',
        'shipping_address_id', 'billing_address_id', 'pickup_product', 'confirmed_by',
        'confirmed_at', 'rejected_by', 'rejected_at', 'submitted_by', 'submitted_at',
        'delivered_by', 'delivered_at', 'paid_at', 'payment_id', 'user_id', 'status_id',
        'company_id', 'offer_id', 'comments', 'created_by', 'updated_by'
    ];

    /*relationships*/
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id', 'id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
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
