<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\CompanyProduct;
use App\Entities\LoanApplication;
use App\Entities\Term;
use App\Entities\Status;
use App\Entities\Currency;
use App\Entities\Group;
use App\Entities\LoanRepaymentSchedule;
use App\User;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Loan extends Model
{

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'id', 'loan_application_id', 'loan_amt', 'loan_bal', 'last_payment_date', 'user_id', 
         'company_user_id', 'account_no', 'account_name',
         'group_id', 'currency_id', 'comments', 'status_id', 'term_id', 'term_value', 
         'company_product_id', 'company_id', 'updated_at', 'updated_by', 'created_at', 'created_by',
         'approved_at', 'approved_by', 'approved_by_name'
    ];


    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function companyproduct()
    {
        return $this->belongsTo(CompanyProduct::class, 'company_product_id', 'id');
    }

    public function term()
    {
        return $this->belongsTo(Term::class); 
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

    public function loanrepaymentschedules()
    {
        return $this->hasMany(LoanRepaymentSchedule::class);
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

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
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
    //end convert dates to local dates


}
