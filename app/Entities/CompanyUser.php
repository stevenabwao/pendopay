<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\DepositAccountSummary;
use App\Entities\CompanyUserArchive;
use App\Entities\Account;
use App\Entities\Status;
use App\Entities\SmsOutbox;
use App\Entities\LoanApplication;
use App\Entities\LoanAccount;
use App\Entities\LoanExposureLimit;
use App\Entities\LoanRepaymentSchedule;
use App\Entities\LoanRepayment;
use App\Entities\BranchGroupMember;
use App\Entities\BranchMember;
use App\Entities\RegistrationPayment;
use App\Entities\SharesAccount;
use App\Entities\SharesAccountHistory;
use App\Entities\SharesAccountSummary;
use App\Events\CompanyUserCreated;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyUser extends Model
{
    //use SoftDeletes; 

    protected $dates = ['deleted_at'];

    protected $table = "company_user";

    protected $events = [
        'created' => CompanyUserCreated::class,
    ];

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'company_id', 'user_id', 'ussd_reg', 'user_cd', 'status_id', 'registration_paid', 
        'company_join_request_id', 'registration_amount_paid', 'created_by', 
        'registration_paid_date', 'updated_by', 'deleted_by', 'comments', 'deleted_at'
    ];

    /*one to many relationship*/
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function companyuserarchives()
    {
        return $this->hasMany(CompanyUserArchive::class, 'id', 'parent_id');
    }
   
    public function loanrepayments()
    {
        return $this->hasMany(LoanRepayment::class);
    }

    public function branchmembers()
    {
        return $this->hasMany(BranchMember::class);
    }

    public function branchgroupmembers()
    {
        return $this->hasMany(BranchGroupMember::class);
    }

    public function companyjoinrequest()
    {
        return $this->hasOne(CompanyJoinRequest::class);
    }

    public function account()
    {
        return $this->hasOne(Account::class, 'id', 'company_user_id');
    }

    public function loanaccounts()
    {
        return $this->hasMany(LoanAccount::class);
    }

    public function loanexposurelimit()
    {
        return $this->hasOne(LoanExposureLimit::class);
    }

    public function registrationpayments()
    {
        return $this->hasMany(RegistrationPayment::class);
    }

    /*many to many relationship*/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function smsoutboxes()
    {
        return $this->hasMany(SmsOutbox::class);
    }

    public function loanapplications()
    {
        return $this->hasMany(LoanApplication::class, 'id', 'company_user_id');
    }

    public function loanrepaymentschedules()
    {
        return $this->hasMany(LoanRepaymentSchedule::class, 'id', 'company_user_id');
    }

    public function sharesaccounts()
    {
        return $this->hasMany(SharesAccount::class);
    }

    public function sharesaccountssummary()
    {
        return $this->hasMany(SharesAccountSummary::class);
    }

    public function sharesaccountshistory()
    {
        return $this->hasMany(SharesAccountHistory::class);
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

        $model = $item->update($attributes);

        return $model;

    }

}
