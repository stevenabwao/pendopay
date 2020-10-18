<?php

namespace App\Entities;

use App\Entities\Status;
use App\Entities\Company;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class County.
 */
class County extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'capital', 'summary', 'desc', 'logo', 'active', 
        'status_id', 'created_by', 'updated_by'
    ];

    protected $table = "counties";

    public function companies() {
        return $this->hasMany(Company::class);
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

}
