<?php

namespace App\Entities;
use App\Entities\Charge;
use App\Entities\Company;
use App\Entities\Currency;
use App\Entities\DepositAccount;
use App\Entities\LoanProductSetting;
use App\Entities\LoanProductSettingsAudit;
use App\Entities\LoanApplication;
use App\Entities\Loan;
use App\Entities\LoanAccount;
use App\Entities\Status;
use App\Entities\ReminderMessageSetting;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{

    protected $fillable = [
          'id', 'name', 'name_2', 'name_3', 'created_by', 'updated_by', 'created_at', 'updated_at'
    ];

    /*one to many relationship*/
    public function loanapplications()
    {
        return $this->hasMany(LoanApplication::class);
    }

    public function loanproductsettings()
    {
        return $this->hasMany(LoanProductSetting::class);
    }
 
    public function loanproductsettingaudits()
    {
        return $this->hasMany(LoanProductSettingsAudit::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function loanaccounts()
    {
        return $this->hasMany(LoanAccount::class);
    }

    public function remindermessagesettings()
    {
        return $this->hasMany(ReminderMessageSetting::class);
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

        //product data
        $product = static::query()->findOrFail($id);

        //do any extra processing here

        $model = $product->update($attributes);

        return $model;

    }


}
