<?php

namespace App\Entities;

use App\BaseModel;
use App\Entities\Company;
use App\Entities\Status;
use App\User;
use Carbon\Carbon;

class Order extends BaseModel
{

    protected $table = "completed_orders";

    protected $dates = ['confirmed_at', 'rejected_at', 'submitted_at', 'delivered_at', 'paid_at'];
    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'id', 'shopping_cart_id', 'total', 'total_calc', 'club_total', 'club_total_calc', 'commission', 'commission_calc',
        'commission_percent', 'total_num_products',
        'unique_num_products', 'currency_id', 'shipping_address_id', 'billing_address_id', 'pickup_product', 'confirmed_by', 'confirmed_by_name',
        'confirmed_at', 'rejected_by', 'rejected_by_name', 'rejected_at', 'submitted_by', 'submitted_by_name', 'submitted_at',
        'delivered_by', 'delivered_by_name', 'delivered_at', 'paid_at', 'paid_by_name', 'payment_id', 'user_id', 'status_id',
        'company_id', 'offer_id', 'comments', 'created_by', 'created_by_name', 'updated_by', 'updated_by_name'
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

    public function shoppingcart()
    {
        return $this->belongsTo(ShoppingCart::class, 'shopping_cart_id', 'id');
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
