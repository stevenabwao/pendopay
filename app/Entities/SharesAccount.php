<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\Account;
use App\Entities\SharesAccountSummary;
use App\Entities\SharesAccountHistory;
use App\Entities\Status;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SharesAccount extends Model
{

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'id', 'ref_account_id', 'account_name', 'account_no', 'ref_account_no', 'currency_id', 
         'status_id', 'company_user_id', 'company_id', 'user_id', 'created_at', 'created_by', 
         'phone', 'updated_at', 'updated_by'
    ];


    public function sharesaccountsummary()
    {
        return $this->hasOne(DepositAccountSummary::class, 'account_no', 'account_no');
    }

    public function sharesaccounthistory()
    {
        return $this->hasMany(DepositAccountHistory::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'ref_account_no', 'account_no');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
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

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id');
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

        //do any extra processing here

        $model = $item->update($attributes);

        return $model;

    }


}
