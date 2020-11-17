<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\EmailQueue;
use App\Entities\Status;
use App\Entities\EmailBatchDetail;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EmailQueueArchive extends Model
{

    protected $dates = ['sent_at'];

    protected $table = "email_queues_archives";

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'parent_id', 'title', 'email_text', 'email_address', 'company_name', 'status_id', 'company_id', 'email_salutation',
        'has_attachments', 'event_type_id', 'table_text', 'parent_id', 'reminder_message_id', 'panel_text', 'item_id',
        'email_footer', 'subject', 'email_batch_id', 'sent_at', 'updated_at', 'updated_by',
        'updated_by_name', 'created_at', 'created_by', 'created_by_name', 'email_provider_name'
    ];

    /*one to many relationship*/
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function emailqueue()
    {
        return $this->belongsTo(EmailQueue::class, 'parent_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function emailbatchdetails()
    {
        return $this->hasMany(EmailBatchDetail::class);
    }
    /*end relationships*/

    //start convert dates to local dates
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }

    public function getSentAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }
    // end convert dates to local dates

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {

        // echo(json_encode($attributes));
        /* if (
            auth()->user()) {
            $user_id = auth()->user()->id;
            $user_full_name = auth()->user()->first_name . " " . auth()->user()->last_name;
            $attributes['created_by'] = $user_id;
            $attributes['created_by_name'] = $user_full_name;
            $attributes['updated_by'] = $user_id;
            $attributes['updated_by_name'] = $user_full_name;
        } */
        // dd("attributes +++ ", $attributes);

        // remove parent id
        // unset($attributes['parent_id']);

        // add parent id
        $attributes['parent_id'] = $attributes['id'];

        // remove id and updated_by fields from array,
        // id will be auto populated (autoincrement field)
        unset($attributes['id']);

        // dd($attributes);

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

        $model = $item->update($attributes);

        return $model;

    }

}
