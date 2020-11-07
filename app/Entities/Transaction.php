<?php

namespace App\Entities;

use App\BaseModel;
use App\Entities\Image;
use App\Entities\Status;
use App\User;

class Transaction extends BaseModel
{

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'id', 'name', 'short_description', 'description', 'paybill_no',  'category_id', 'can_sell',
        'physical_address', 'contact_person', 'box', 'phone', 'personal_phone', 'street_address',
        'town', 'personal_email', 'email', 'latitude', 'longitude', 'status_id', 'county_id',
        'facebook_url', 'twitter_url','instagram_url', 'phone_country', 'created_by', 'created_by_name',
        'updated_by', 'updated_by_name'
    ];

    /*relationships*/
    public function county()
    {
        return $this->belongsTo(County::class);
    }

    public function category()
    {
        return $this->belongsTo(EstCategory::class, 'category_id', 'id');
    }

    /* polymorphic relationship \'*/
    public function images() {
        return $this->morphMany(Image::class, 'imagetable');
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

    // add accessor for full permalink
    public function getFullPermalinkAttribute()
    {
        return $this->id . '-' . $this->permalink;
    }

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
    public function getDisplayNameAttribute()
    {
        return strtoupper($this->name);
    }
    //end convert dates to local dates

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {

        //dd($attributes);

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
