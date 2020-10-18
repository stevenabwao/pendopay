<?php

namespace App;

use App\User;
use App\Permission;

use Illuminate\Database\Eloquent\Model;

// use Laratrust\Models\LaratrustRole;

class Role extends Model
{

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

	//start convert dates to local dates
    /* public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    } */
    //end convert dates to local dates
}
