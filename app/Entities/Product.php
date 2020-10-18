<?php

namespace App\Entities;
use App\Entities\Status;
use App\Entities\CompanyProduct;
use App\Entities\Currency;
use App\Entities\ProductAudit;
use App\Entities\ProductCategory;
use App\Entities\Image;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
          'id', 'name', 'description', 'recommended_price', 'currency_id', 'product_category_id', 'status_id',
          'product_category_id', 'permalink', 'created_by', 'updated_by', 'created_at', 'updated_at'
    ];

    /*one to many relationship*/
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function productcategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }

    /* polymorphic relationship \'*/
    public function images() {
        return $this->morphMany(Image::class, 'imagetable');
    }

    public function productaudits()
    {
        return $this->hasMany(ProductAudit::class);
    }

    public function offerproducts()
    {
        return $this->hasMany(OfferProduct::class);
    }

    public function companyproducts()
    {
        return $this->hasMany(CompanyProduct::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    // scopes
    public function scopeStatus($query, $arg)
    {
        return $query->where('status_id', $arg);
    }
    /* usage::
       $post = Product::status(1)->get(); // Active
       $post = Product::status(99)->get(); // Inactive
    */

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

        $user_id = auth()->user()->id;

        $attributes['created_by'] = $user_id;
        $attributes['updated_by'] = $user_id;

        $model = static::query()->create($attributes);

        return $model;

    }

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function updatedata($id, array $attributes = [])
    {

        $user_id = auth()->user()->id;

        $attributes['updated_by'] = $user_id;

        //product data
        $product = static::query()->findOrFail($id);

        //dd($attributes);

        $model = $product->update($attributes);

        return $model;

    }


}
