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

class OrderItem extends Model
{

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'id', 'order_id', 'total', 'club_total', 'commission', 'commission_percent', 'currency_id', 'company_id', 'user_id',
        'status_id', 'offer_id', 'shopping_cart_id', 'quantity', 'unit_price', 'offer_product_id',
        'company_product_id', 'product_id', 'product_name', 'comments', 'created_by', 'created_by_name',
        'updated_by', 'updated_by_name'
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

    public function offerproduct()
    {
        return $this->belongsTo(OfferProduct::class, 'offer_product_id', 'id');
    }

    public function shoppingcart()
    {
        return $this->belongsTo(ShoppingCart::class, 'shopping_cart_id', 'id');
    }

    public function companyproduct()
    {
        return $this->belongsTo(CompanyProduct::class, 'offer_product_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
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

    // accessors
    public function getProductNameAttribute()
    {

        if ($this->product) {
            return $this->product->name;
        } else {
            return "";
        }

    }

    public function getFormattedUnitPriceAttribute()
    {

        if ($this->unit_price) {
            return formatCurrency($this->unit_price);
        } else {
            return "";
        }

    }

    public function getFormattedTotalAttribute()
    {

        if ($this->total) {
            return formatCurrency($this->total);
        } else {
            return "";
        }

    }

    public function getFormattedQuantityAttribute()
    {

        if ($this->quantity) {
            return format_num($this->quantity, 0);
        } else {
            return "";
        }

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
