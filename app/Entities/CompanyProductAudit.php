<?php

namespace App\Entities;
use App\Entities\Company;
use App\Entities\CompanyProduct;
use App\Entities\OfferProduct;
use App\Entities\Product;
use App\Entities\Currency;
use App\Entities\Status;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CompanyProductAudit extends Model
{

    protected $fillable = [
          'id', 'parent_id', 'product_id', 'name', 'company_id', 'currency_id', 
          'status_id', 'price', 'permalink',
          'created_by', 'updated_by', 'created_at', 'updated_at'
    ];

    /*relationships*/
    public function establishment()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function companyproduct()
    {
        return $this->belongsTo(CompanyProduct::class, 'parent_id', 'id');
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


}
