<?php

namespace App\Entities;

use App\BaseModel;
use App\Entities\DepositAccountSummary;
use App\Entities\DepositAccountHistory;
use App\Entities\Status;
use App\User;

class DepositAccountAudit extends BaseModel
{

    protected $dates = ['opened_at', 'available_at', 'closed_at'];

    protected $casts = [
        'opened_at' => 'datetime',
        'available_at' => 'datetime',
        'closed_at' => 'datetime'
    ];

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'parent_id', 'account_name', 'account_no', 'currency_id', 'phone', 'opened_at', 'status_id',
         'company_user_id', 'available_at', 'closed_at', 'user_id', 'created_by', 'created_by_name',
         'updated_by', 'updated_by_name'
    ];


    public function depositaccount()
    {
        return $this->belongsTo(DepositAccount::class, 'parent_id', 'id');
    }

    public function depositaccountsummary()
    {
        return $this->belongsTo(DepositAccountSummary::class, 'account_no', 'account_no');
    }

    public function depositaccounthistory()
    {
        return $this->hasMany(DepositAccountHistory::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
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

    // start getters
    public function getOpenedAtAttribute($value)
    {
        return showLocalizedDate($value);
    }
    public function getAvailableAtAttribute($value)
    {
        return showLocalizedDate($value);
    }
    public function getClosedAtAttribute($value)
    {
        return showLocalizedDate($value);
    }
    // end getters

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {

        //add parent id
        $attributes['parent_id'] = $attributes['id'];

        //remove id and updated_by fields from array,
        //id will be auto populated (autoincrement field)
        unset($attributes['id']);

        $model = static::query()->create($attributes);

        return $model;

    }

}
