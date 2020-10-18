<?php

namespace App\Entities;
use App\Entities\Status;
use App\Entities\CompanyProduct;
use App\Entities\Currency;
use App\Entities\Company;
use App\Entities\ProductCategory;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Till extends Model
{

    protected $fillable = [
          'id', 'phone_number', 'till_name', 'till_number', 'company_id', 'active', 'status_id',
          'confirmed_at', 'created_by', 'updated_by', 'created_at', 'updated_at'
    ];

    /*one to many relationship*/
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
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
