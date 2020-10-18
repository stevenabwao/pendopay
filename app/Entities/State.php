<?php

namespace App\Entities;

use App\Entities\City;
use App\Entities\Country;
use App\Entities\Status;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class State.
 */
class State extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'state_id', 'status_id', 'created_by', 'updated_by', 'deleted_by', 'deleted_at'
    ];

    public function users() {
        return $this->hasMany(User::class);
    }

    public function status() {
        return $this->belongsTo(Status::class);
    }

    public function country() {
        return $this->belongsTo(Country::class);
    }

    public function cities() {
        return $this->hasMany(City::class);
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

}
