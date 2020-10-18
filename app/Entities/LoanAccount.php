<?php

namespace App\Entities;

use App\Entities\Company; 
use App\Entities\Currency;
use App\Entities\Product;
use App\Entities\Status;
use App\Entities\Term;
use App\Entities\CompanyUser;
use App\Entities\LoanApplication;
use App\Entities\LoanRepaymentSchedule;
use App\Entities\LoanRepayment;
use App\Entities\LoanAccountAudit;
use App\Entities\Account;
use App\Entities\ReminderMessage;
use App\Events\LoanAccountCreated;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoanAccount extends Model
{

    protected $dates = ['last_repayment_at', 'start_at', 'maturity_at', 'final_repayment_at', 'original_maturity_at'];

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'id', 'account_name', 'account_no', 'ref_account_id', 'currency_id', 'user_id', 'company_user_id', 'counter',
         'company_id', 'status_id', 'loan_application_id', 'start_at', 'loan_amt', 'loan_amt_calc', 'loan_bal', 
         'loan_bal_calc', 'repayment_amt', 'repayment_amt_calc', 'maturity_at', 'last_repayment_at', 
         'final_repayment_at', 'original_maturity_at', 'company_product_id', 
         'term_id', 'term_value', 'created_at', 'created_by', 'updated_at', 'updated_by' 
    ];


    /*model events*/
    protected $events = [
        'created' => LoanAccountCreated::class,
    ];


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function companyproduct()
    {
        return $this->belongsTo(CompanyProduct::class);
    }

    public function companyuser()
    {
        return $this->belongsTo(CompanyUser::class, 'company_user_id', 'id');
    }

    public function loanapplication()
    {
        return $this->belongsTo(LoanApplication::class, 'loan_application_id', 'id');
    }

    public function loanaccountaudits()
    {
        return $this->hasMany(LoanAccountAudit::class);
    }

    public function loanrepaymentschedules()
    {
        return $this->hasMany(LoanRepaymentSchedule::class);
    }

    public function loanrepayments()
    {
        return $this->hasMany(LoanRepayment::class);
    }
    
    public function remindermessages()
    {
        return $this->hasMany(ReminderMessage::class);
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

        //branch data
        $loanapplication = static::query()->findOrFail($id);

        //do any extra processing here

        $model = $loanapplication->update($attributes);

        return $model;

    }


}
