<?php

namespace App\Entities;

use App\BaseModel;
use App\Entities\Company;
use App\Entities\Account;
use App\Entities\PaymentArchive;
use App\Entities\PaymentMethod;
use App\Entities\PaymentDeposit;
use App\Events\PaymentCreated;
use App\Entities\GlAccountHistory;
use App\User;
use Carbon\Carbon;

class Payment extends BaseModel
{

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
        'amount', 'currency_id', 'payment_method_id', 'company_id', 'company_name', 'account_no',
        'account_name', 'paybill_number', 'phone', 'full_name', 'updated_by_name', 'shares',
        'trans_id', 'src_ip', 'trans_time', 'date_stamp', 'modified', 'processed', 'processed_at', 'failed',
        'failed_at', 'fail_times', 'fail_reason', 'comments', 'updated_by', 'created_at', 'updated_at',
        'reposted_at', 'reposted_by'
    ];

    protected $dates = [
        'reposted_at', 'failed_at', 'processed_at', 'date_stamp'
    ];

    protected $events = [
        'created' => PaymentCreated::class,
    ];

    /*start relationships*/
    public function paymentmethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function paymentdeposit()
    {
        return $this->hasOne(PaymentDeposit::class);
    }

    public function glaccounthistory()
    {
        return $this->hasMany(GlAccountHistory::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function paymentarchives()
    {
        return $this->hasMany(PaymentArchive::class, 'parent_id', 'id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_no', 'account_no');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    /*end relationships*/


    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {
        try {
            $model = static::query()->create($attributes);
        } catch (\Exception $e) {
            // dd($e);
            log_this($e->getMessage());
        }
        return $model;
    }

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function updatedata($id, array $attributes = [])
    {
        // data
        $item = static::query()->findOrFail($id);
        $model = $item->update($attributes);
        return $model;
    }

    // start getters
    public function getProcessedAtAttribute($value)
    {
        return showLocalizedDate($value);
    }

    public function getRepostedAtAttribute($value)
    {
        return showLocalizedDate($value);
    }

    public function getFailedAtAttribute($value)
    {
        return showLocalizedDate($value);
    }
    // end getters

    // start setters/ mutators
    public function setProcessedAtAttribute($date)
    {
        $this->attributes['processed_at'] = formatUTCDate($date);
    }
    public function setRepostedAtAttribute($date)
    {
        $this->attributes['reposted_at'] = formatUTCDate($date);
    }
    public function setFailedAtAttribute($date)
    {
        $this->attributes['failed_at'] = formatUTCDate($date);
    }
    // end setters/ mutators

}
