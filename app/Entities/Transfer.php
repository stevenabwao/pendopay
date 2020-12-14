<?php

namespace App\Entities;

use App\BaseModel;
use App\Entities\Company;
use App\Entities\CompanyUser;
use App\Entities\Status;
use App\Entities\TransferAudit;
use App\User;
use App\Events\TransferCreated;
use App\Events\TransferUpdated;

class Transfer extends BaseModel
{

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'id', 'source_account_type', 'source_account_id', 'source_account_name', 'source_user_id', 'destination_user_id',
         'source_company_user_id', 'destination_company_user_id', 'source_phone', 'destination_phone',
         'destination_account_type', 'destination_account_id', 'destination_account_name',
         'amount', 'comments', 'status_id', 'company_id', 'source_account_no', 'destination_account_no',
         'created_at', 'created_by', 'updated_at', 'updated_by'
    ];

    public function sourceuser()
    {
        return $this->belongsTo(User::class, 'source_user_id', 'id');
    }

    public function destinationuser()
    {
        return $this->belongsTo(User::class, 'destination_user_id', 'id');
    }

    public function sourcecompanyuser()
    {
        return $this->belongsTo(CompanyUser::class, 'source_company_user_id', 'id');
    }

    public function destinationcompanyuser()
    {
        return $this->belongsTo(CompanyUser::class, 'destination_company_user_id', 'id');
    }

    public function transferaudits()
    {
        return $this->hasMany(TransferAudit::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    /* start accessors */
    // add accessor for trans date
    /* public function getFormattedTransactionDateAttribute()
    {
        return formatDatePickerDate($this->transaction_date, 'd-M-Y');
    } */

    public function getUrlAttribute()
    {

        // link to show
        $url = route('my-transfers.show', ['id'=>$this->id]);

        return $url;

    }

    // add accessor for trans amount
    public function getFormattedAmountAttribute()
    {
        return formatCurrency($this->amount);
    }
    public function getFormattedTransferAmountAttribute()
    {
        return formatCurrency($this->amount);
    }
    /* end accessors */

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {

        $model = static::query()->create($attributes);

        // start call create event
        event(new TransferCreated($model));
        // end call update event

        return $model;

    }

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function updatedata($id, array $attributes = [])
    {

        //item data
        $item = static::query()->findOrFail($id);

        $model = $item->update($attributes);

        // start call update event
        event(new TransferUpdated($item->fresh()));
        // end call update event

        return $model;

    }

}
