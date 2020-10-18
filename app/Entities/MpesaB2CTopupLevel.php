<?php

namespace App\Entities;

use App\Entities\Company; 
use App\Entities\Currency;
use App\Entities\Status;
use App\Events\MpesaB2CTopupLevelCreated;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MpesaB2CTopupLevel extends Model
{

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'id', 'currency_id', 'company_id', 'status_id', 'amount', 
         'created_at', 'created_by', 'updated_at', 'updated_by' 
    ];

    protected $table = "mpesab2c_topup_levels";

    /*model events*/
    protected $events = [
        'created' => MpesaB2CTopupLevelCreated::class,
    ];


    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
        //class, foreign key, local key
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


    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {

        $user_id = auth()->user()->id;

        $attributes['created_by'] = $user_id;
        $attributes['updated_by'] = $user_id;

        $model = static::query()->create($attributes);

        return $model;

    }

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function updatedata($id, array $attributes = [])
    {

        $user_id = auth()->user()->id;

        $attributes['updated_by'] = $user_id;

        //branch data
        $loanapplication = static::query()->findOrFail($id);

        //do any extra processing here

        $model = $loanapplication->update($attributes);

        return $model;

    }


}
