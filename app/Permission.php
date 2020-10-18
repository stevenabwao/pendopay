<?php

namespace App;

use App\Role;

use Illuminate\Database\Eloquent\Model;

// use Laratrust\Models\LaratrustPermission;

class Permission  extends Model
{
	/*protected $fillable = [
	   'name', 'uuid', 'display_name', 'description',
    ];*/

    public function roles()
    {
        return $this->belongsToMany(Role::class);
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
