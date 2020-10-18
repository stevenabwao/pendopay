<?php

namespace App\Entities;
use App\Entities\Company;
use App\Entities\CompanyProductAudit;
use App\Entities\OfferProduct;
use App\Entities\Product;
use App\Entities\Currency;
use App\Entities\Status;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CompanyProduct extends Model
{

    protected $fillable = [
          'id', 'product_id', 'name', 'company_id', 'currency_id', 'permalink', 'status_id', 'price',
          'created_by', 'created_by_name', 'updated_by', 'updated_by_name'
    ];

    /*relationships*/
    public function establishment()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function companyproductaudits()
    {
        return $this->hasMany(CompanyProductAudit::class);
    }

    public function offerproducts()
    {
        return $this->hasMany(OfferProduct::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
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
       $post = CompanyProduct::status(1)->get(); // Active
       $post = CompanyProduct::status(99)->get(); // Inactive
    */

    // add accessor for club url
    public function getUrlAttribute()
    {

        $app_url = config('app.url');
        $restaurant_cat_id = config('constants.establishments.restaurant_cat_id');

        $link_text = config('constants.establishments.club_cat_text');
        if ($this->attributes['category_id'] == $restaurant_cat_id) {
            $link_text = config('constants.establishments.restaurant_cat_text');
        }

        // generate url
        $the_url = $app_url . "/$link_text/" . $this->attributes['id'] . '-' . $this->attributes['permalink'];

        return $the_url;

    }

    // add accessor for product name
    public function getProductNameAttribute()
    {

        if ($this->product) {
            return $this->product->name;
        } else {
            return "";
        }

    }

    // add accessor for image
    public function getMainImageAttribute()
    {

        $no_image_url = config('constants.images.no_image_thumb_400');
        $img_path = "";

        // dd("this-product === ", $this->product);

        if (count($this->product->images)) {
            if ($this->product->images[0]->thumb_img_400) {
                $img_path = $this->product->images[0]->thumb_img_400;
            } else {
                $img_path = $no_image_url;
            }

        } else {
            $img_path = $no_image_url;
        }

        return getFullImagePath($img_path);

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

        //item data
        $item = static::query()->findOrFail($id);

        $model = $item->update($attributes);

        return $model;

    }


}
