<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\Account;
use App\Entities\CompanyUser;
use App\Entities\Payment;
use App\Entities\PaymentMethod;
use App\Entities\PaymentDeposit;
use App\Entities\GlAccountHistory;
use App\User;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PaymentArchive extends Model
{

    //use SoftDeletes;

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
        'parent_id', 'amount', 'currency_id', 'payment_method_id', 'company_id', 'company_name', 'account_no', 
        'account_name', 'paybill_number', 'phone', 'full_name', 'shares', 
        'trans_id', 'src_ip', 'trans_time', 'date_stamp', 'modified', 'processed', 'processed_at', 'failed',
        'failed_at', 'fail_times', 'fail_reason', 'comments', 'updated_by', 'created_at', 'updated_at',
        'reposted_at', 'reposted_by', 'deleted_at', 'deleted_by'
    ];

    protected $dates = [
        'reposted_at', 'deleted_at', 'failed_at', 'processed_at', 'date_stamp'
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

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_no', 'account_no');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'id', 'parent_id');
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
    /*end relationships*/


    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {

        if (auth()->user()) {
            $user_id = auth()->user()->id;

            $attributes['created_by'] = $user_id;
        }

        //add parent id
        $attributes['parent_id'] = $attributes['id'];

        //remove id and updated_by fields from array, 
        //id will be auto populated (autoincrement field)
        unset($attributes['id']);

        $model = static::query()->create($attributes);

        return $model;

    }


    //start convert dates to local dates
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }

    public function getProcessedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }

    public function getRepostedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }

    public function getDeletedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }
    //end convert dates to local dates


}
