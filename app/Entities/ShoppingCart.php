<?php

namespace App\Entities;

use App\BaseModel;
use App\Entities\Company;
use App\Entities\Status;
use App\User;

class ShoppingCart extends BaseModel
{

    protected $dates = ['submitted_at'];

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'id', 'total', 'total_num_products', 'unique_num_products', 'currency_id', 'company_id', 'user_id',
        'status_id', 'offer_id', 'comments', 'total_calc', 'paid_amount', 'paid_amount_calc', 'balance_calc', 'balance',
        'created_by', 'created_by_name', 'updated_by', 'updated_by_name', 'submitted_at', 'submitted_by',
        'submitted_by_name', 'submitted_times'
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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id', 'id');
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function shoppingcartaudits()
    {
        return $this->hasMany(ShoppingCartAudit::class);
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

    public function getFormattedTotalAttribute()
    {

        if ($this->total) {
            return formatCurrency($this->total_calc);
        } else {
            return "";
        }

    }

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {

        //dd($attributes);

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

        $model = $item->update($attributes);

        return $model;

    }

}
