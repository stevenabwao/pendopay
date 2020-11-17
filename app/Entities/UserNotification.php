<?php

namespace App\Entities;

use App\BaseModel;
use App\Entities\Image;
use App\Entities\Status;
use App\User;

class UserNotification extends BaseModel
{

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'id', 'user_id', 'notification_message', 'notification_link', 'notification_section', 'notification_section_id',
        'read_status', 'read_at', 'status_id', 'created_by', 'created_by_name', 'updated_by', 'updated_by_name'
    ];

    /* relationships */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
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

        //item data
        $item = static::query()->findOrFail($id);

        $model = $item->update($attributes);

        return $model;

    }

}
