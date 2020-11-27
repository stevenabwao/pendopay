<?php

namespace App\Entities;

use App\BaseModel;
use App\Entities\Image;
use App\Entities\Status;
use App\User;

class TransactionAudit extends BaseModel
{

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'id', 'parent_id', 'title', 'transaction_amount', 'transaction_date', 'seller_user_id',  'buyer_user_id',
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

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {

        //add parent id
        $attributes['parent_id'] = $attributes['id'];

        // remove id and updated_by fields from array,
        // id will be auto populated (autoincrement field)
        unset($attributes['id']);

        $model = static::query()->create($attributes);

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

        return $model;

    }

}
