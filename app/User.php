<?php

namespace App;

use App\Entities\Company;
use App\Entities\CompanyUser;
use App\Entities\DepositAccount;
use App\Entities\DepositAccountHistory;
use App\Entities\DepositAccountSummary;
use App\Entities\Image;
use App\Entities\MpesaB2CTopupLevel;
use App\Entities\OauthAccessToken;
use App\Entities\ReminderMessageCategory;
use App\Entities\ReminderMessageSetting;
use App\Entities\ReminderMessageType;
use App\Entities\ReportDataSummaryDetail;
use App\Entities\SmsOutbox;
use App\Entities\Status;
use App\Entities\Transaction;
use App\Entities\UserAccessToken;
use App\Entities\UserAudit;
use App\Role;
use App\Entities\UserLogin;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use App\Events\UserCreated;
use App\Events\UserUpdated;

class User extends Authenticatable
{

    use HasApiTokens;
    use Notifiable;
    use LaratrustUserTrait;

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'dob', 'password', 'password2', 'gender', 'status_id', 'active',
        'remember_token', 'password_text', 'id_no', 'is_super_admin',
        'phone', 'phone_country', 'api_token', 'src_ip', 'user_agent', 'browser', 'browser_version', 'os', 'device',
        'dob_updated', 'dob_updated_at', 'created_by', 'created_by_name', 'updated_by', 'updated_by_name', 'is_company_user'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'dob' => 'datetime',
        'dob_updated_at' => 'datetime'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
    */
    // protected $dates = ['dob', 'dob_updated_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'password2', 'remember_token', 'api_token',
    ];

    // start roles  //////////////////////

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    // end //////////////////////

    /*relation between token and user*/
    public function token() {
        return $this->hasMany(OauthAccessToken::class);
    }

    public function useraccesstoken() {
        return $this->hasOne(UserAccessToken::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function useraudits()
    {
        return $this->hasMany(UserAudit::class);
    }

    public function userlogins()
    {
        return $this->hasMany(UserLogin::class);
    }

    public function companyusers()
    {
        return $this->hasMany(CompanyUser::class);
    }

    public function depositaccount()
    {
        return $this->hasOne(DepositAccount::class);
    }

    public function depositaccounthistory()
    {
        return $this->hasMany(DepositAccountHistory::class);
    }

    public function depositaccountsummary()
    {
        return $this->hasMany(DepositAccountSummary::class);
    }

    public function remindermessagesettings()
    {
        return $this->hasMany(ReminderMessageSetting::class);
    }

    public function mpesab2ctopuplevels()
    {
        return $this->hasMany(MpesaB2CTopupLevel::class);
    }


    /* polymorphic relationship \'*/
    public function images() {
        return $this->morphMany(Image::class, 'imagetable');
    }

    /*many to many relationship*/
    public function companies()
    {
        return $this->belongsToMany(Company::class)
            ->withPivot('created_by', 'updated_by')
            ->withTimestamps();
    }

    public function smsOutboxes()
    {
        return $this->hasMany(SmsOutbox::class);
    }

    public function remindermessagetypes()
    {
        return $this->hasMany(ReminderMessageType::class);
    }

    public function remindermessagecategories()
    {
        return $this->hasMany(ReminderMessageCategory::class);
    }

    public function reportdatasummarydetails()
    {
        return $this->hasMany(ReportDataSummaryDetail::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public static function getUser()
    {
        $user_id = auth()->user();
        $userCompany = User::where('id', auth()->user()->id)->with('company')->first();
        return $userCompany;
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

    // start mutators/ setters
    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = getDatabasePhoneNumber($value);
    }
    // end mutators/ setters

    // getters
    public function getAgeAttribute() {
        // return the age of this user
        return getDateDiff($this->dob);
    }

    public function getFirstNameAttribute($value)
    {
        return titlecase($value);
    }

    public function getLastNameAttribute($value)
    {
        return titlecase($value);
    }

    // return user full name
    public function getFullNameAttribute($value)
    {
        return titlecase($this->first_name) .' '. titlecase($this->last_name);
    }

    // return user gender name
    public function getGenderNameAttribute()
    {
        return $this->gender == 'm' ? "Male" : "Female";
    }

    // return user type name
    public function getUserTypeAttribute()
    {
        return $this->is_company_user == '1' ? "Company User" : "Normal User";
    }

    // return company name
    public function getCompanyNameAttribute()
    {
        return $this->company ? $this->company->name : "";
    }

    //start convert dates to local dates
    public function getCreatedAtAttribute($value)
    {
        return showLocalizedDate($value);
    }

    public function getUpdatedAtAttribute($value)
    {
        return showLocalizedDate($value);
    }

    public function getDobAttribute($value)
    {
        return showLocalizedDate($value);
    }

    public function getDobUpdatedAtAttribute($value)
    {
        return showLocalizedDate($value);
    }
    //end convert dates to local dates

    /*get user for passport login*/
    public function findForPassport($username) {

        $status_active = getStatusActive();
        // dd($status_active);

        if (isValidEmail($username)) {

            // dd("ema");
            return $this->where('active', $status_active)
                        ->where('status_id', $status_active)
                        ->where('email', $username)
                        ->first();

        } else {

            // dd("fon");
            return $this->where('active', $status_active)
                        ->where('status_id', $status_active)
                        ->where('phone', getDatabasePhoneNumber($username))
                        ->first();

        }

    }

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {

        // dd($attributes);

        if (isLoggedIn()) {
            $user = getLoggedUser();
            $user_id = $user->id;
            $user_full_names = $user->full_name;

            $attributes['created_by'] = $user_id;
            $attributes['created_by_name'] = $user_full_names;
            $attributes['updated_by'] = $user_id;
            $attributes['updated_by_name'] = $user_full_names;
        }

        if (array_key_exists('gender', $attributes)) {
            $attributes['gender'] = strtolower($attributes['gender']);
        }

        $model = static::query()->create($attributes);

        // start call create event
        event(new UserCreated($model));
        // end call update event

        return $model;

    }


    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function updatedata($id, array $attributes = [])
    {

        if (isLoggedIn()) {
            $user = getLoggedUser();
            $user_id = $user->id;
            $user_full_names = $user->full_name;

            $attributes['updated_by'] = $user_id;
            $attributes['updated_by_name'] = $user_full_names;
        }

        // user data
        $user = static::query()->findOrFail($id);

        $model = $user->update($attributes);

        // start call update event
        event(new UserUpdated($user->fresh()));
        // end call update event

        return $model;

    }

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function updateUserPassword(array $attributes = [])
    {

        if (isLoggedIn()) {
            $user = getLoggedUser();
            $user_id = $user->id;
            $user_full_names = $user->full_name;

            $attributes['updated_by'] = $user_id;
            $attributes['updated_by_name'] = $user_full_names;
        }

        $attributes['password'] = Hash::make($attributes['new_password']);

        // get user
        $user = static::query()->findOrFail($user_id);

        // update password
        $model = $user->update($attributes);

        //start call update event
        event(new UserUpdated($user->fresh()));
        //end call update event

        return $model;

    }


}

