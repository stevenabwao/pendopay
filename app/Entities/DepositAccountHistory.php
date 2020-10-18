<?php

namespace App\Entities;

use App\BaseModel;
use App\Entities\DepositAccount;
use App\Entities\DepositAccountSummary;
use App\Entities\Status;
use App\Entities\CompanyUser;
use App\User;

class DepositAccountHistory extends BaseModel
{

    protected $table = 'deposit_account_history';

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'id', 'parent_id', 'account_no', 'currency_id', 'dr_cr_ind', 'trans_desc', 'trans_ref_txt',
         'user_id', 'amount', 'current_balance', 'mpesa_code', 'status_id', 'created_at', 'created_by_name',
         'created_by', 'updated_at', 'updated_by', 'updated_by_name'
    ];


    public function depositaccount()
    {
        return $this->belongsTo(DepositAccount::class, 'account_no', 'account_no');
    }

    public function depositaccountsummary()
    {
        return $this->belongsTo(DepositAccountSummary::class, 'parent_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function companyuser()
    {
        return $this->belongsTo(CompanyUser::class, 'user_id', 'id');
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


    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {

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
