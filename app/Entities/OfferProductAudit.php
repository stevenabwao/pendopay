<?php

namespace App\Entities;
use App\Entities\Status;
use App\Entities\CompanyProduct;
use App\Entities\Offer;
use App\Entities\OfferProduct;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class OfferProductAudit extends Model
{

    protected $fillable = [
          'id', 'parent_id', 'offer_id', 'company_id', 'company_product_id', 'normal_price', 
          'offer_price', 'status_id', 
          'discount_percent', 'created_by', 'updated_by', 'created_at', 'updated_at'
    ];

    /*one to many relationship*/
    public function establishment()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function offerproduct()
    {
        return $this->belongsTo(OfferProduct::class, 'parent_id', 'id');
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id', 'id');
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

        try{
            $model = static::query()->create($attributes);
        } catch (\Exception $e) {
            dd($e);
        }

        return $model;

    }


}
