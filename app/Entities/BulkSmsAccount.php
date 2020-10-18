<?php

namespace App\Entities;

use App\Entities\Group;
use App\Entities\SmsOutbox;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BulkSmsAccount extends Model
{
    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'name', 'description', 'physical_address', 'box', 'phone', 'email', 'latitude', 'longitude'
    ];

    protected $appends = ['groups'];

    /*one to many relationship*/
    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    /*one to many relationship*/
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function smsoutboxes()
    {
        return $this->hasMany(SmsOutbox::class);
    }

    public function getGroupsAttribute()
    {
        $groups = Group::where('company_id', $this->id)
                 ->get();        
        return $groups;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
        //foreign key, local key
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    

    //start convert dates to local dates
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }
    //end convert dates to local dates


}
