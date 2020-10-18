<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\DepositAccount; 
use App\Entities\Group;
use App\Entities\CompanyProduct;
use App\Entities\CompanyUser;
use App\Entities\Status;
use App\Entities\Term;
use App\Entities\Currency;
use App\Entities\LoanApplicationAudit;
use App\Entities\LoanExposureLimit;
use App\Events\LoanApplicationCreated;
use App\Events\LoanAccount;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoanApplication extends Model
{

    protected $dates = ['deleted_at', 'applied_at', 'expiry_at', 'approved_expiry_at', 'decline_at', 
    'validity_expiration_at', 'membership_date'];

    /*model events*/
    protected $events = [
        'created' => LoanApplicationCreated::class,
    ];

    /**
     * The attributes that are mass assignable 
    **/
    protected $fillable = [
         'user_id', 'company_user_id', 'company_id', 'group_id', 'deposit_account_id', 'applied_at', 
         'expiry_at', 'approved_expiry_at', 'deposit_account_no', 'current_contributions',
         'interest_type', 'interest_amount', 'interest_method', 'interest_cycle', 'approved_at', 
         'approved_by', 'approved_by_name', 'declined_by', 'declined_by_name', 'allowed_loan_amt',
         'currency_id', 'loan_amt', 'prime_limit_amt', 'approved_limit_amt', 'decline_at', 
         'company_product_id', 'validity_expiration_at', 'contributions_at_application', 'exposure_limit_at_application',
         'contributions_at_application_comments', 'membership_date', 'membership_age_limit', 'membership_age_limit_amt',
         'comments', 'status_id', 'term_id', 'term_value', 'approved_term_id', 'approved_term_value', 
         'created_at', 'created_by', 'updated_at', 'updated_by'
    ]; 

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function companyproduct()
    {
        return $this->belongsTo(CompanyProduct::class, 'company_product_id', 'id');
    }

    public function companyuser()
    {
        return $this->belongsTo(CompanyUser::class, 'company_user_id', 'id');
    }

    public function depositaccount()
    {
        return $this->belongsTo(DepositAccount::class, 'deposit_account_id', 'id');
    }

    public function loanaccount()
    {
        return $this->hasOne(LoanAccount::class);
    }

    public function approvedterm()
    {
        return $this->belongsTo(Term::class, 'approved_term_id', 'id');
    }

    public function term()
    {
        return $this->belongsTo(Term::class); 
    }

    public function loanapplicationaudits()
    {
        return $this->hasMany(LoanApplicationAudit::class); 
    }

    public function interestcycle()
    {
        return $this->belongsTo(Term::class, 'interest_cycle', 'id');
    }

    public function loandurationcycle()
    {
        return $this->belongsTo(Term::class, 'loan_duration_cycle', 'id');
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

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    public function decliner()
    {
        return $this->belongsTo(User::class, 'declined_by', 'id');
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

    public function getAppliedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }

    public function getExpiryAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }

    public function getApprovedExpiryAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }

    public function getApprovedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }

    public function getDeclinedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }

    public function getValidityExpirationAtAttribute($value)
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

        //dd($attributes);
        $user = auth()->user();

        if ($user) {
            $user_id = auth()->user()->id;

            $attributes['created_by'] = $user_id;
            $attributes['updated_by'] = $user_id;
        }

        try{
            $model = static::query()->create($attributes);
        } catch (\Exception $e) {
            //dd($e);
        }

        return $model;

    }

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function updatedata($id, array $attributes = [])
    {

        $user = auth()->user();
        $user_id = $user->id;

        $loanapplication = "";

        /*
        if ($user->hasRole('superadministrator')) {
            //if user is superadmin, show
            $loanapplication = static::query()->find($id);
        } else if ($user->hasRole('administrator')){
            //if user is not superadmin, show only from user company
            $loanapplication = static::query()->where('company_id', $user->company->id)
                                ->where('id', $id)
                                ->first();
        }
        */

        $loanapplication = static::query()->find($id);

        //if user is valid, proceed
        if ($loanapplication) {

            $attributes['updated_by'] = $user_id;

            //loanapplication data
            $loanapplication = static::query()->findOrFail($id);

            //do any extra processing here
            $model = $loanapplication->update($attributes);

            return $model;

        } else {

            abort(404);

        }

    }


}
