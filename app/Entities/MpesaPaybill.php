<?php

namespace App\Entities;

use App\Entities\Company;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MpesaPaybill extends Model
{
    protected $fillable = [
        'name', 'description', 'paybill_number', 'till_number', 'type', 'company_branch_id', 'company_id'
    ];

    /*one to many relationship*/
    public function company()
    {
        return $this->belongsTo(Company::class);
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
