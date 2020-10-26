<?php

namespace App\Entities;

use App\Entities\Account;
use App\Entities\Company;
use App\Entities\CompanyJoinRequest;
use App\Entities\CompanyUser;
use App\Entities\DepositAccount;
use App\Entities\DepositAccountSummary;
use App\Entities\DepositAccountHistory;
use App\Entities\Group;
use App\Entities\Image;
use App\Entities\LoanApplication;
use App\Entities\LoanAccount;
use App\Entities\SmsOutbox;
use App\Entities\Status;
use App\Entities\LoanExposureLimit;
use App\Entities\LoanRepaymentSchedule;
use App\Entities\ReminderMessageType;
use App\Entities\ReminderMessageSetting;
use App\Entities\ReminderMessageCategory;
use App\Entities\RegistrationPayment;
use App\Entities\SharesAccount;
use App\Entities\SharesAccountHistory;
use App\Entities\SharesAccountSummary;
use App\Entities\MpesaB2CTopupLevel;
use App\Entities\ReportDataSummaryDetail;
use App\Entities\SupervisorClientAssign;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserArchiveOld extends Model
{

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'first_name', 'parent_id', 'uuid', 'last_name', 'email', 'dob', 'password', 'gender', 'status_id', 'company_id', 'active',
        'state_id', 'city_id', 'constituency_id', 'ward_id', 'remember_token', 'access_token', 'refresh_token', 'password_text',
        'phone', 'phone_country', 'api_token', 'src_ip', 'user_agent', 'browser', 'browser_version', 'os', 'device',
        'dob_updated', 'dob_updated_at', 'created_by', 'updated_by', 'created_at', 'updated_at', 'is_company_user',
        'id_no', 'state_name', 'constituency_name' , 'amount', 'registration_paid', 'super_admin'

    ];

    /*object events*/
    /*
    protected $events = [
        'created' => Events\UserCreated::class,
    ];
    */

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
    */
    protected $dates = ['dob', 'dob_updated_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token', 'access_token', 'refresh_token',
    ];

    /*relations*/
    public function user() {
        return $this->belongsTo(User::class, 'parent_id', 'id');
    }

    public function companyusers()
    {
        return $this->hasMany(CompanyUser::class);
    }

    public function companyjoinrequests()
    {
        return $this->hasMany(CompanyJoinRequest::class);
    }

    public function loanapplications()
    {
        return $this->hasMany(LoanApplication::class);
    }

    public function loanaccounts()
    {
        return $this->hasMany(LoanAccount::class);
    }

    public function loanexposurelimits()
    {
        return $this->hasMany(LoanExposureLimit::class);
    }

    public function depositaccounts()
    {
        return $this->hasMany(DepositAccount::class);
    }

    public function depositaccounthistory()
    {
        return $this->hasMany(DepositAccountHistory::class);
    }

    public function depositaccountsummary()
    {
        return $this->hasMany(DepositAccountSummary::class);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function remindermessagesettings()
    {
        return $this->hasMany(ReminderMessageSetting::class);
    }

    public function registrationpayments()
    {
        return $this->hasMany(RegistrationPayment::class);
    }

    public function mpesab2ctopuplevels()
    {
        return $this->hasMany(MpesaB2CTopupLevel::class);
    }

    public function supervisorclientassigns()
    {
        return $this->hasMany(SupervisorClientAssign::class);
    }

    /* polymorphic relationship \'*/
    public function images() {
        return $this->morphMany(Image::class, 'imagetable');
    }

    /*many to many relationship*/
    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /*many to many relationship*/
    /* public function companies()
    {
        return $this->belongsToMany(Company::class)
            ->withPivot('created_by', 'updated_by')
            ->withTimestamps();
    } */

    public function smsOutboxes()
    {
        return $this->hasMany(SmsOutbox::class);
    }

    public function loanrepaymentschedules()
    {
        return $this->hasMany(LoanRepaymentSchedule::class);
    }

    public function remindermessagetypes()
    {
        return $this->hasMany(ReminderMessageType::class);
    }

    public function remindermessagecategories()
    {
        return $this->hasMany(ReminderMessageCategory::class);
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

    public function reportdatasummarydetails()
    {
        return $this->hasMany(ReportDataSummaryDetail::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
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

    public function getUserCompanyAttribute()
    {
        $company = Company::findOrFail($this->company_id)->first();
        return $company;
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
