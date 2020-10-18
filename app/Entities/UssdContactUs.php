<?php

namespace App\Entities;

use App\Entities\Company;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UssdContactUs extends Model
{

    
    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
        'phone', 'company_id', 'message'
    ];


    protected $table = "ussd_contact_us";


    /*relationships*/
    public function company() {
        return $this->belongsTo(Company::class);
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
