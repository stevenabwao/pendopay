<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\CompanyUser;
use App\Entities\Currency;
use App\Entities\Payment;
use App\Entities\Product;
use App\Entities\Status;
use App\Entities\DepositAccountSummary;
use App\Entities\DepositAccount;
use App\Entities\LoanAccount;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class OverdueReminder extends Model 
{

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'id', 'account_name', 'account_no', 'phone', 'currency_id', 'product_id', 'company_id', 
         'status_id', 'company_user_id', 'user_id', 'created_at', 'created_by', 
         'updated_at', 'updated_by', 'deleted_at', 'deleted_by'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function companyuser()
    {
        return $this->belongsTo(CompanyUser::class, 'company_user_id', 'id');
    }

    public function payments()
    {
        return $this->belongsTo(Payment::class, 'account_no', 'account_no');
    }

    public function company()
    {
        return $this->belongsTo(Company::class); 
    }

    public function depositaccountsummary()
    {
        return $this->hasOne(DepositAccountSummary::class, 'account_no', 'account_no'); 
    }

    public function depositaccounts()
    {
        return $this->hasMany(DepositAccount::class, 'ref_account_no', 'account_no');
    }

    public function loanaccounts()
    {
        return $this->hasMany(LoanAccount::class, 'id', 'ref_account_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
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
