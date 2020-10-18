<?php

namespace App\Entities;

use App\BaseModel;
use App\Entities\Status;
use App\Entities\CompanyProduct;
use App\Entities\Product;
use App\Entities\Offer;
use App\Entities\Currency;
use App\Entities\OfferProductAudit;
use App\User;
use Carbon\Carbon;

class OfferProduct extends BaseModel
{

    protected $fillable = [
          'id', 'offer_id', 'company_product_id', 'company_id', 'product_id', 'currency_id', 'normal_price',
          'offer_price', 'status_id', 'discount_percent', 'created_by', 'updated_by',
          'created_at', 'updated_at'
    ];

    /*one to many relationship*/
    public function establishment()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id', 'id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function offerproductaudits()
    {
        return $this->hasMany(OfferProductAudit::class);
    }

    public function companyproduct()
    {
        return $this->belongsTo(CompanyProduct::class, 'company_product_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    // add accessor for full permalink
    public function getFullPermalinkAttribute()
    {
        return $this->id . '-' . $this->permalink;
    }

    // TODO:: add accessor for url
    public function getUrlAttribute()
    {

        /* $app_url = config('app.url');
        $restaurant_cat_id = config('constants.establishments.restaurant_cat_id');

        $link_text = config('constants.establishments.club_cat_text');
        if ($this->company->attributes['category_id'] == $restaurant_cat_id) {
            $link_text = config('constants.establishments.restaurant_cat_text');
        }

        // generate url
        $the_url = $app_url . "/$link_text/" . $this->company->attributes['id'] . '-';
        $the_url .= $this->company->attributes['permalink'] . '/offers/';
        $the_url .= $this->attributes['id'] . '-' . $this->attributes['permalink'];

        // new url
        // $the_url = $app_url . "/offers/" . $this->attributes['id'] . '-' . $this->attributes['permalink'];

        // offers/{id}

        return $the_url; */

    }

    // add accessor for image
    public function getMainImageAttribute()
    {

        $no_image_url = config('constants.images.no_image_thumb_400');
        $img_path = $no_image_url;

        if ($this->companyproduct) {
            if ($this->companyproduct->product) {
                if (count($this->companyproduct->product->images)) {
                    if ($this->companyproduct->product->images[0]->thumb_img_400 != null) {
                        $img_path = $this->companyproduct->product->images[0]->thumb_img_400;
                    }
                }
            }
        }

        return getFullImagePath($img_path);

    }

    // add accessor for product name
    public function getProductNameAttribute()
    {

        if ($this->companyproduct) {
            if ($this->companyproduct->product) {
                return $this->companyproduct->product->name;
            } else {
                return "";
            }
        } else {
            return "";
        }

    }

    // add accessor for offer name
    public function getOfferNameAttribute()
    {
        if ($this->offer) {
            return $this->offer->name;
        } else {
            return "";
        }
    }

    // add accessor for company name
    public function getCompanyNameAttribute()
    {
        if ($this->company) {
            return $this->company->name;
        } else {
            return "";
        }
    }

    // add accessor for min qty
    public function getMinQuantityAttribute()
    {

        $beer_category = config('constants.product_category.beer');
        $beer_min_qty = config('constants.product_min_qty.beer');

        if ($this->companyproduct->product_category_id == $beer_category) {
            return $beer_min_qty;
        } else {
            return 1;
        }
    }

    // add accessor for min cost = min_qty X price
    public function getMinCostAttribute()
    {
        if ($this->min_quantity) {
            return $this->min_quantity * $this->offer_price;
        } else {
            return "";
        }
    }

    // add accessor for offer expiry date
    public function getOfferExpiryDateAttribute()
    {
        if ($this->offer) {
            return $this->offer->expiry_at;
        }
    }

    // start accessors for prices
    public function getFullFormattedNormalPriceAttribute()
    {
        return formatCurrency($this->normal_price);
    }

    public function getFormattedNormalPriceAttribute()
    {
        return format_num($this->normal_price);
    }

    public function getFullFormattedOfferPriceAttribute()
    {
        return formatCurrency($this->offer_price);
    }

    public function getFormattedOfferPriceAttribute()
    {
        return formatCurrency($this->offer_price);
    }
    // end accessors for prices


    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {

        // dd($attributes);

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

        $product = static::query()->findOrFail($id);

        // dd($attributes);

        $model = $product->update($attributes);

        return $model;

    }


}
