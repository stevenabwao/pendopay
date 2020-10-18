<?php

namespace App\Entities;

use App\BaseModel;
use App\Entities\DepositAccountSummary;
use App\Entities\DepositAccountHistory;
use App\Entities\Status;
use App\User;
use Carbon\Carbon;

class DepositAccount extends BaseModel
{

    protected $dates = ['opened_at', 'available_at', 'closed_at'];

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'id', 'account_name', 'account_no', 'currency_id', 'phone', 'opened_at', 'status_id', 'company_user_id',
         'available_at', 'closed_at', 'user_id', 'created_at', 'created_by', 'created_by_name',
         'updated_at', 'updated_by', 'updated_by_name'
    ];


    public function depositaccountsummary()
    {
        return $this->belongsTo(DepositAccountSummary::class, 'account_no', 'account_no');
    }

    public function depositaccounthistory()
    {
        return $this->hasMany(DepositAccountHistory::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
        //class, foreign key, local key
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    // start getters
    public function getOpenedAtAttribute($value)
    {
        return showLocalizedDate($value);
    }
    public function getAvailableAtAttribute($value)
    {
        return showLocalizedDate($value);
    }
    public function getClosedAtAttribute($value)
    {
        return showLocalizedDate($value);
    }
    // end getters

    // start setters/ mutators
    /* public function setOpenedAtAttribute($date)
    {
        $this->attributes['opened_at'] = formatUTCDate($date);
    }
    public function setAvailableAtAttribute($date)
    {
        $this->attributes['available_at'] = formatUTCDate($date);
    }
    public function setClosedAtAttribute($date)
    {
        $this->attributes['closed_at'] = formatUTCDate($date);
    } */
    // end setters/ mutators


    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {

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

        //do any extra processing here

        $model = $item->update($attributes);

        return $model;

    }


}
