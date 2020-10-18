<?php

namespace App\Entities;

use App\Entities\SharesAccount;
use App\Entities\SharesAccountSummary;
use App\Entities\Company;
use App\Entities\Status;
use App\Entities\CompanyUser;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SharesAccountHistory extends Model
{

    protected $table = 'shares_account_history';

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'id', 'parent_id', 'account_no', 'currency_id', 'dr_cr_ind', 'trans_desc', 'trans_ref_txt', 
         'company_user_id', 'user_id', 'amount', 'company_id', 'currency_id',
         'status_id', 'created_at', 'created_by_name', 'created_by', 'updated_at', 'updated_by', 'updated_by_name'
    ];


    public function sharesaccount()
    {
        return $this->belongsTo(SharesAccount::class, 'account_no', 'account_no');
    }

    public function sharesaccountsummary()
    {
        return $this->belongsTo(SharesAccountSummary::class, 'parent_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function companyuser()
    {
        return $this->belongsTo(CompanyUser::class, 'user_id', 'id');
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

        //do any extra processing here

        $model = $item->update($attributes);

        return $model;

    }


}
