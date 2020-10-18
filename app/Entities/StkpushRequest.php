<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\Status;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class StkpushRequest extends Model
{

    protected $table = 'stkpush_requests';

    protected $dates = ['submitted_at'];
    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'id', 'phone', 'paybill', 'currency_id', 'amount', 'acc_ref', 'user_id', 'status_id', 'company_id', 'offer_id',
        'shopping_cart_id', 'created_by', 'created_by_name', 'updated_by', 'updated_by_name'
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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id', 'id');
    }

    public function shoppingcart()
    {
        return $this->hasOne(ShoppingCart::class, 'shopping_cart_id', 'id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
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

    //start convert dates to local dates
    public function getCreatedAtAttribute($value)
    {
        return showLocalizedDate($value);
    }

    public function getUpdatedAtAttribute($value)
    {
        return showLocalizedDate($value);
    }

    public function getSubmittedAtAttribute($value)
    {
        return showLocalizedDate($value);
    }
    //end convert dates to local dates

    public function getFormattedAmountAttribute()
    {

        if ($this->amount) {
            return formatCurrency($this->amount);
        } else {
            return "";
        }

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
