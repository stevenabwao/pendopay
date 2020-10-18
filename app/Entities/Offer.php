<?php

namespace App\Entities;

use App\BaseModel;
use App\Entities\Company;
use App\Entities\OfferProduct;
use App\Entities\Image;
use App\Entities\Status;
use App\User;

class Offer extends BaseModel
{

    protected $dates = ['expiry_at', 'start_at', 'end_at'];

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'id', 'name', 'description', 'min_age', 'max_age', 'num_sales', 'max_sales',
        'expiry_at', 'start_at', 'end_at', 'offer_day', 'offer_frequency',
        'offer_type', 'num_products', 'offer_expiry_method', 'status_id',
        'company_id', 'permalink', 'expiry_email', 'created_by', 'created_by_name',
        'updated_by', 'updated_by_name'
    ];

    /*relationships*/
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function activeofferproducts()
    {
        $status_active = config("constants.status.active");
        return $this->hasMany(OfferProduct::class)->status($status_active);
    }

    public function offerproducts()
    {
        return $this->hasMany(OfferProduct::class);
    }

    public function offerproductsdisplay()
    {
        return $this->hasMany(OfferProduct::class)->take(5);
    }

    public function cheapestofferproducts()
    {
        return $this->hasOne(OfferProduct::class)->orderBy('discount_percent', 'desc')->limit(1);
    }

    public function highestdiscountofferproduct()
    {
        return $this->hasOne(OfferProduct::class)->orderBy('discount_percent', 'desc')->limit(1);
    }

    public function shoppingcarts()
    {
        return $this->hasMany(ShoppingCart::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /* polymorphic relationship \'*/
    public function images() {
        return $this->morphMany(Image::class, 'imagetable');
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

    // add accessor for url
    public function getUrlAttribute()
    {

        $app_url = config('app.url');
        $restaurant_cat_id = config('constants.establishments.restaurant_cat_id');

        $link_text = config('constants.establishments.club_cat_text');
        if ($this->company->attributes['category_id'] == $restaurant_cat_id) {
            $link_text = config('constants.establishments.restaurant_cat_text');
        }

        // generate url
        $the_url = $app_url . "/$link_text/" . $this->company->attributes['id'] . '-';
        $the_url .= $this->company->attributes['permalink'] . '/offers/';
        $the_url .= $this->attributes['id'] . '-' . $this->attributes['permalink'];

        // $the_url = route('offers.showClubOffer', ['company_link' => $company_link, 'offer_link' => $offer_link]);

        // route('post.show', ['post' => 1]);

        // new url
        // $the_url = $app_url . "/offers/" . $this->attributes['id'] . '-' . $this->attributes['permalink'];

        // offers/{id}

        return $the_url;

    }

    // add accessor for image
    public function getMainImageAttribute()
    {

        $no_image_url = getNoImageThumb400();
        $img_path = "";

        if (count($this->images)) {
            if ($this->images[0]->thumb_img_400) {
                $img_path = $this->images[0]->thumb_img_400;
            } else {
                $img_path = $no_image_url;
            }
        } else {
            $img_path = $no_image_url;
        }

        return getFullImagePath($img_path);

    }

    //start convert dates to local dates
    public function getExpiryAtAttribute($value)
    {
        return showLocalizedDate($value);
    }

    public function getStartAtAttribute($value)
    {
        return showLocalizedDate($value);
    }

    public function getEndAtAttribute($value)
    {
        return showLocalizedDate($value);
    }

    /* public function getNameAttribute($value)
    {
        return $value;
    } */

    public function getDisplayNameAttribute()
    {
        return strtoupper($this->name);
    }
    //end convert dates to local dates

    // scopes
    public function scopeHasProducts($query, $arg)
    {
        return $query->where('num_products', '>', $arg);
    }
    /* usage::
       $post = Offer::has_products(1)->get(); // at least one product
    */

    public function scopePopular($query, $arg)
    {
        return $query->orderBy('hits', 'desc')->take($arg);
    }

    /* scopes */
    /* public function scopeOfferProducts (Builder $query, $name) {
        return $query->where('status', function ($q) use ($name) {
                $q->where('name', $name);
        });
    } */

    // start setters/ mutators
    public function setStartAtAttribute($date)
    {
        $this->attributes['start_at'] = formatUTCDate($date);
    }
    public function setEndAtAttribute($date)
    {
        $this->attributes['end_at'] = formatUTCDate($date);
    }
    public function setExpiryAtAttribute($date)
    {
        $this->attributes['expiry_at'] = formatUTCDate($date);
    }
    // end setters/ mutators

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {

        //dd($attributes);
        // add slug/ permalink
        $attributes['permalink'] = getStrSlug($attributes['name']);

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
        //dd($id, $attributes);

        //item data
        $item = static::query()->findOrFail($id);

        $model = $item->update($attributes);

        return $model;

    }

}
