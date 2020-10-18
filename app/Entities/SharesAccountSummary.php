<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\CompanyUser;
use App\Entities\LoanApplication;
use App\Entities\SharesAccount;
use App\Entities\SharesAccountHistory;
use App\Entities\Product;
use App\Entities\Status;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SharesAccountSummary extends Model
{

    protected $table = 'shares_account_summary'; 

    protected $dates = ['last_activity_date', 'last_deposit_date', 'last_withdrawal_date'];

    /**
     * The attributes that are mass assignable
    **/ 
    protected $fillable = [
        'id', 'account_no', 'account_name', 'company_id', 'company_user_id', 'currency_id', 
        'ledger_balance', 'cleared_balance', 'last_activity_date', 'phone', 'user_id', 
        'last_deposit_date', 'last_deposit_amount', 'last_withdrawal_date', 'last_withdrawal_amount', 'dr_count',
        'çr_count', 'status_id', 'updated_by_name',
        'created_at', 'created_by_name', 'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'
   ];

   public function sharesaccount()
   {
       return $this->belongsTo(SharesAccount::class, 'account_no', 'account_no');
   }

   public function sharesaccounthistory()
   {
       return $this->hasMany(SharesAccountHistory::class); 
   }

   public function companyuser()
   {
       return $this->belongsTo(CompanyUser::class, 'company_user_id', 'id');
   }

   public function user()
   {
       return $this->belongsTo(User::class, 'user_id', 'id');
   }

   public function loanapplications()
   {
       return $this->hasMany(LoanApplication::class);
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

   public function getDeletedAtAttribute($value)
   {
       return Carbon::parse($value)->timezone(getLocalTimezone());
   }

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
