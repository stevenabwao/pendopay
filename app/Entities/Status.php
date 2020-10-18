<?php

namespace App\Entities;

use App\Entities\Account;
use App\Entities\Company;
use App\Entities\CompanyUser;
use App\Entities\Category;
use App\Entities\ConfirmCode;
use App\Entities\Country;
use App\Entities\State;
use App\Entities\Currency;
use App\Entities\PaymentMethod;
use App\Entities\DepositAccount;
use App\Entities\Image;
use App\Entities\LoanApplication;
use App\Entities\Loan;
use App\Entities\LoanAccount;
use App\Entities\Product;
use App\Entities\Asset;
use App\Entities\AssetType;
use App\Entities\UssdEventType;
use App\Entities\UssdEventMap;
use App\Entities\LoanExposureLimit;
use App\Entities\LoanRepaymentSchedule;
use App\Entities\CompanyBranch;
use App\Entities\CompanyBranchUser;
use App\Entities\BranchGroup;
use App\Entities\BranchMember;
use App\Entities\ReminderSetting;
use App\Entities\ReminderMessage;
use App\Entities\ReminderMessageType;
use App\Entities\ReminderMessageCategory;
use App\Entities\SharesAccount;
use App\Entities\SharesAccountSummary;
use App\Entities\SharesAccountHistory;
use App\Entities\MpesaB2CTopupLevel;
use App\Entities\EmailProvider;
use App\Entities\EmailProviderSetting;
use App\Entities\Order;
use App\Entities\Offer;
use App\Entities\MediaTemplate;
use App\Entities\MediaTemplateAudit;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'id', 'name', 'section'
    ];

    public function paymentmethods()
    {
        return $this->hasMany(PaymentMethod::class);
    }

    public function countries()
    {
        return $this->hasMany(Country::class);
    }

    public function states()
    {
        return $this->hasMany(State::class);
    }

    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function loanaccounts()
    {
        return $this->hasMany(LoanAccount::class);
    }

    public function companyusers()
    {
        return $this->hasMany(CompanyUser::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function loanexposurelimits()
    {
        return $this->hasMany(LoanExposureLimit::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function smsoutboxes()
    {
        return $this->hasMany(SmsOutbox::class);
    }

    public function loanapplications()
    {
        return $this->hasMany(LoanApplication::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function currencies()
    {
        return $this->hasMany(Currency::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function depositaccounts()
    {
        return $this->hasMany(DepositAccount::class);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function assettypes()
    {
        return $this->hasMany(AssetType::class);
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function schedulesmsoutboxes()
    {
        return $this->hasMany(ScheduleSmsOutbox::class);
    }

    public function loanrepaymentschedules()
    {
        return $this->hasMany(LoanRepaymentSchedule::class);
    }

    public function confirmcodes()
    {
        return $this->hasMany(ConfirmCode::class);
    }

    public function ussdeventtypes()
    {
        return $this->hasMany(UssdEventType::class);
    }

    public function ussdeventmaps()
    {
        return $this->hasMany(UssdEventMap::class);
    }

    public function companybranches()
    {
        return $this->hasMany(CompanyBranch::class);
    }

    public function companybranchusers()
    {
        return $this->hasMany(CompanyBranchUser::class);
    }

    public function branchgroups()
    {
        return $this->hasMany(BranchGroup::class);
    }

    public function branchmembers()
    {
        return $this->hasMany(BranchMember::class);
    }

    public function remindersettings()
    {
        return $this->hasMany(ReminderSetting::class);
    }

    public function remindermessages()
    {
        return $this->hasMany(ReminderMessage::class);
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

    public function sharesaccountshistory()
    {
        return $this->hasMany(SharesAccountHistory::class);
    }

    public function sharesaccountssummary()
    {
        return $this->hasMany(SharesAccountSummary::class);
    }

    public function mpesab2ctopuplevels()
    {
        return $this->hasMany(MpesaB2CTopupLevel::class);
    }

    public function emailproviders()
    {
        return $this->hasMany(EmailProvider::class);
    }

    public function emailprovidersettings()
    {
        return $this->hasMany(EmailProviderSetting::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function mediatemplates()
    {
        return $this->hasMany(MediaTemplate::class);
    }

    public function mediatemplateaudits()
    {
        return $this->hasMany(MediaTemplateAudit::class);
    }


    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {

        $model = static::query()->create($attributes);

        return $model;

    }

}
