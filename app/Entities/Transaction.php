<?php

namespace App\Entities;

use App\BaseModel;
use App\Entities\Image;
use App\Entities\Status;
use App\Entities\TransactionAccount;
use App\Events\TransactionCreated;
use App\Events\TransactionUpdated;
use App\User;

class Transaction extends BaseModel
{

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'id', 'title', 'transaction_amount', 'transaction_date', 'seller_user_id',  'buyer_user_id',
        'transaction_amount_paid', 'transaction_balance',
        'transaction_description', 'status_id', 'created_by', 'created_by_name', 'updated_by', 'updated_by_name'
    ];

    /* polymorphic relationship \'*/
    public function images() {
        return $this->morphMany(Image::class, 'imagetable');
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

    public function transactionrequests()
    {
        return $this->hasMany(TransactionRequest::class);
    }

    public function transactionaccount()
    {
        return $this->hasOne(TransactionAccount::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    // add accessor for full permalink
    public function getFullPermalinkAttribute()
    {
        return $this->id . '-' . $this->permalink;
    }

    // add accessor for url
    public function getUrlAttribute()
    {

        if ($this->status_id == getStatusInactive()) {
            // link to create step 2
            $url = route('my-transactions.create-step2', ['id'=>$this->id]);
        } else {
            // link to show
            $url = route('my-transactions.show', ['id'=>$this->id]);
        }

        return $url;

    }

    // add accessor for percentage paid
    public function getPercentagePaidAttribute()
    {
        return ($this->transaction_amount_paid/ $this->transaction_amount) * 100;
    }

    // add accessor for trans date
    public function getFormattedTransactionDateAttribute()
    {
        return formatDatePickerDate($this->transaction_date, 'd-M-Y');
    }

    // add accessor for trans amount
    public function getFormattedTransactionAmountAttribute()
    {
        return formatCurrency($this->transaction_amount);
    }

    // add accessor for trans amount paid
    /* public function getTransactionAmountPaidAttribute()
    {
        $trans_amount_paid = 0;
        if($this->transaction_amount_paid){
            $trans_amount_paid = $this->transaction_amount_paid;
        }
        return $trans_amount_paid;
    } */

    // add accessor for formatted trans amount paid
    public function getFormattedTransactionAmountPaidAttribute()
    {
        return formatCurrency($this->transaction_amount_paid);
    }

    // add accessor for trans balance
    /* public function getTransactionBalanceAttribute()
    {
        return formatCurrency($this->transaction_balance);
    } */

    // add accessor for whether to show deposit funds to transaction
    public function getShowDepositToTransactionAttribute()
    {

        // if logged user is a buyer and transaction is in active status, show button to deposit funds to this transaction
        if((getTransactionRole($this) == getTransactionRoleBuyer()) && ($this->status_id == getStatusActive())) {
            return true;
        }
        return false;
    }

    // add accessor for formatted trans balance
    public function getFormattedTransactionBalanceAttribute()
    {
        return formatCurrency($this->transaction_balance);
    }

    // add accessor for user role in trans
    public function getUserTransactionRoleAttribute()
    {
        if (getLoggedUser()->id == $this->seller_user_id) {
            return 'SELLER';
        } else if (getLoggedUser()->id == $this->buyer_user_id) {
            return 'BUYER';
        } else {
            return '';
        }
    }

    // add accessor for transaction account no
    public function getTransactionAccountNoAttribute()
    {
        $transaction_account = "";
        if($this->transactionaccount){
            $transaction_account = $this->transactionaccount->account_no;
        }
        return $transaction_account;
    }

    // add accessor for image
    public function getMainImageAttribute()
    {

        $no_image_url = getNoImageThumb400();
        $img_path = "";

        if (count($this->images)) {
            if ($this->images[0]->thumb_img_400) {
                $img_path = $this->images[0]->thumb_img_400;
            } else {
                $img_path = $no_image_url;
            }

        } else {
            $img_path = $no_image_url;
        }

        return getFullImagePath($img_path);

    }

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {

        // dd("in create", $attributes);
        $model = static::query()->create($attributes);

        // start call create event
        event(new TransactionCreated($model));
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

        // start call create event
        event(new TransactionUpdated($item->fresh()));
        // end call update event

        return $model;

    }

}
