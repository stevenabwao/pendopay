<?php

namespace App;

use App\Deposit;
use App\Loan;
use App\Role;
use App\User;
use App\Withdrawal;
use Carbon\Carbon;
use Laratrust\LaratrustTeam;

class Team extends LaratrustTeam
{
    
    protected $fillable = [
        'name', 'description', 'physical_address', 'box', 'phone', 'email', 'latitude', 'longitude'
    ];

    
    /*team users*/
    public function users() {
        return $this->hasMany(RoleUser::class, 'team_id', 'id');
        //class, foreign key, local key
    }

    /*many to many relationship*/
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user', 'team_id', 'role_id')
            ->withPivot('account_balance', 'account_number', 'account_type_id', 'created_by', 'updated_by', 'created_at', 'updated_at')
            ->withTimestamps();
    }

    /*withdrawals relationship*/
    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    /*deposits relationship*/
    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    /*deposits relationship*/
    public function loans()
    {
        return $this->hasMany(Loan::class);
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
