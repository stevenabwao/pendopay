<?php

namespace App\Entities;

use App\Entities\State;
use App\User;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User.
 */
class City extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'state_id', 'status_id', 'created_by', 'updated_by', 'deleted_by', 'deleted_at'
    ];


    public function state() {
        return $this->belongsTo(State::class);
    }

    public function status() {
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

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id');
    }

}
