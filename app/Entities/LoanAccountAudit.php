<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\Currency;
use App\Entities\Product;
use App\Entities\Status;
use App\Entities\Term;
use App\Entities\CompanyUser;
use App\Entities\LoanApplication;
use App\Entities\LoanAccount;
use App\Entities\LoanRepaymentSchedule;
use App\Entities\LoanRepayment;
use App\Entities\Account;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoanAccountAudit extends Model
{

    protected $table = "loan_accounts_audits";

    protected $dates = ['last_repayment_at', 'start_at', 'maturity_at', 'final_repayment_at', 'original_maturity_at'];

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'id', 'parent_id', 'account_name', 'account_no', 'ref_account_id', 'currency_id', 'user_id', 'company_user_id', 'counter',
         'company_id', 'status_id', 'loan_application_id', 'start_at', 'loan_amt', 'loan_bal', 'loan_bal_calc', 'loan_amt_calc', 
         'repayment_amt', 'repayment_amt_calc', 'maturity_at', 'last_repayment_at', 'final_repayment_at', 'original_maturity_at', 
         'company_product_id', 'term_id', 'term_value', 'created_at', 'created_by', 'updated_at', 'updated_by' 
    ];


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function companyproduct()
    {
        return $this->belongsTo(CompanyProduct::class);
    }

    public function loanaccount()
    {
        return $this->belongsTo(LoanAccount::class, 'parent_id', 'id');
    }

    public function companyuser()
    {
        return $this->belongsTo(CompanyUser::class);
    }

    public function loanapplication()
    {
        return $this->belongsTo(LoanApplication::class, 'loan_application_id', 'id');
    }

    public function loanrepaymentschedules()
    {
        return $this->hasMany(LoanRepaymentSchedule::class);
    }

    public function loanrepayments()
    {
        return $this->hasMany(LoanRepayment::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'ref_account_id', 'id');
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
         }
 
         //add parent id
         $attributes['parent_id'] = $attributes['id'];
 
         //remove id and updated_by fields from array, 
         //id will be auto populated (autoincrement field)
         unset($attributes['id']);
 
         $model = static::query()->create($attributes);
 
         return $model;
 
     }
 
     /**
      * @param array $attributes
      * @return \Illuminate\Database\Eloquent\Model
      */
     public static function updatedata($id, array $attributes = [])
     { 
 
         //dd($attributes, $id);
 
         $user_id = auth()->user()->id;
         $attributes['updated_by'] = $user_id;
         
 
         //item data
         $item = static::query()->findOrFail($id);
 
         
 
         $model = $item->update($attributes);
 
         //dd($model, $attributes);
 
         return $model;
 
     }


}
