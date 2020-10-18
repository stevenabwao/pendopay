<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\CompanyUser;
use App\Entities\LoanAccount;
use App\Entities\LoanRepaymentAudit;
use App\Entities\Status;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LoanRepayment extends Model
{

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'id', 'loan_account_id', 'payment_id', 'loan_account_no', 'company_user_id', 'amount', 'ref_txt',
         'company_id', 'updated_at', 'updated_by', 'created_at', 'created_by'
    ];


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function companyuser()
    {
        return $this->belongsTo(CompanyUser::class, 'company_user_id', 'id');
    }

    public function loanrepaymentaudits()
    {
        return $this->hasMany(LoanRepaymentAudit::class);
    }

    public function loanaccount()
    {
        return $this->belongsTo(LoanAccount::class, 'loan_account_id', 'id');
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

    //start convert dates to local dates
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }


    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }

    public function getRepaymentAtAttribute($value)
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
