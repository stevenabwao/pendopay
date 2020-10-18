<?php

namespace App\Entities;

use App\BaseModel;
use App\Entities\DepositAccount;
use App\Entities\DepositAccountHistory;
use App\Entities\Status;
use App\User;
use Carbon\Carbon;

class DepositAccountSummary extends BaseModel
{

    protected $dates = ['last_activity_date', 'last_deposit_date', 'last_withdrawal_date'];

    protected $table = 'deposit_account_summary';

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'id', 'parent_id', 'account_no', 'currency_id', 'ledger_balance', 'cleared_balance', 'last_activity_date',
         'phone', 'user_id', 'last_deposit_date', 'last_deposit_amount', 'last_withdrawal_date',
         'last_withdrawal_amount', 'dr_count', 'çr_count', 'total_charges', 'total_cost', 'status_id',
         'updated_by_name', 'created_at', 'created_by_name', 'created_by', 'updated_at', 'updated_by'
    ];


    public function depositaccount()
    {
        return $this->hasOne(DepositAccount::class, 'account_no', 'account_no');
    }

    public function depositaccounthistory()
    {
        return $this->hasMany(DepositAccountHistory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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


    //start convert dates to local dates
    public function getLastActivityDatetAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }

    public function getLastDepositDatetAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }

    public function getLastWithdrawalDatetAttribute($value)
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
