<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\LoanApplication;
use App\Entities\DepositAccountSummary;
use App\Entities\DepositAccountHistory;
use App\Entities\Product;
use App\Entities\Status;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Deposit extends Model 
{

    //use SoftDeletes;

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
        'amount', 'payment_id', 'company_id', 'company_user_id', 'company_name', 'account_no', 'account_name', 
        'narration', 'updated_by', 'created_at', 'updated_at'
    ];

    /*start relationships*/
    public function companyuser()
    {
        return $this->belongsTo(CompanyUser::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_no', 'account_no');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id');
    }
    /*end relationships*/


    /**
      * @param array $attributes
      * @return \Illuminate\Database\Eloquent\Model
      */
    public static function create(array $attributes = [])
    {

        //create new payment
        $model = static::query()->create($attributes);

        return $model;

    }


    //start convert dates to local dates
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }

    public function getProcessedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }

    public function getRepostedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }
    //end convert dates to local dates


}
