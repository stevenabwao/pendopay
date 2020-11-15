<?php

namespace App\Entities;

use App\BaseModel;
use App\Entities\TransactionAccountSummary;
use App\Entities\TransactionAccountHistory;
use App\Entities\Status;
use App\User;

class TransactionAccountAudit extends BaseModel
{

    protected $dates = ['opened_at', 'available_at', 'closed_at', 'seller_accepted_at', 'buyer_accepted_at'];

    protected $casts = [
        'opened_at' => 'datetime',
        'available_at' => 'datetime',
        'closed_at' => 'datetime',
        'seller_accepted_at' => 'datetime',
        'buyer_accepted_at' => 'datetime'
    ];

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'parent_id', 'account_name', 'account_no', 'transaction_id', 'currency_id', 'opened_at', 'status_id', 'company_user_id',
         'seller_user_id', 'buyer_user_id', 'seller_accepted_at', 'buyer_accepted_at', 'available_at', 'closed_at',
         'created_by', 'created_by_name', 'updated_by', 'updated_by_name'
    ];


    public function transactionaccountsummary()
    {
        return $this->belongsTo(TransactionAccountSummary::class, 'account_no', 'account_no');
    }

    public function transactionaccounthistories()
    {
        return $this->hasMany(TransactionAccountHistory::class);
    }

    public function transactionaccount()
    {
        return $this->belongsTo(TransactionAccount::class, 'parent_id', 'id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_user_id', 'id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_user_id', 'id');
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

    public function getSellerAcceptedAtAttribute($value)
    {
        return showLocalizedDate($value);
    }

    public function getBuyerAcceptedAtAttribute($value)
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

        $attributes['parent_id'] = $attributes['id'];

        // remove id and updated_by fields from array,
        // id will be auto populated (autoincrement field)
        unset($attributes['id']);

        $model = static::query()->create($attributes);

        return $model;

    }

}
