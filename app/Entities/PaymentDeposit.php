<?php

namespace App\Entities;

use App\BaseModel;
use App\Entities\Company;
use App\Entities\Account;
use App\Entities\PaymentMethod;
use App\Entities\Payment;
use App\Entities\GlAccountHistory;
use App\User;
use Carbon\Carbon;

class PaymentDeposit extends BaseModel
{

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
        'payment_id', 'amount', 'currency_id', 'payment_method_id', 'company_id', 'company_name', 'account_no',
        'account_name', 'paybill_number', 'phone', 'full_name',
        'trans_id', 'src_ip', 'trans_time', 'date_stamp', 'modified', 'processed', 'processed_at', 'failed',
        'failed_at', 'fail_times', 'fail_reason', 'comments', 'updated_by', 'created_at', 'updated_at',
        'reposted_at', 'reposted_by'
    ];

    protected $dates = [
        'reposted_at', 'failed_at', 'processed_at', 'date_stamp'
    ];

    /*start relationships*/
    public function paymentmethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function glaccounthistory()
    {
        return $this->hasMany(GlAccountHistory::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
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

            //dd($attributes);
            //create new payment
            $model = static::query()->create($attributes);
            return $model;

        } catch (\Exception $e){

            // dd($e);
            log_this($e->getMessage());

        }

    }

    //start convert dates to local dates
    public function getProcessedAtAttribute($value)
    {
        return showLocalizedDate($value);
    }

    public function getRepostedAtAttribute($value)
    {
        return showLocalizedDate($value);
    }
    //end convert dates to local dates

    // start setters/ mutators
    public function setProcessedAtAttribute($date)
    {
        $this->attributes['processed_at'] = formatUTCDate($date);
    }
    public function setRepostedAtAttribute($date)
    {
        $this->attributes['reposted_at'] = formatUTCDate($date);
    }
    // end setters/ mutators


}
