<?php

namespace App\Entities;

use App\Entities\LoanProductSetting;
use App\Entities\LoanProductSettingsAudit;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoanLimitCalculation extends Model
{

    protected $table = "loan_limit_calculations";

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [

        'id', 'name', 'code', 'comments', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status_id'  

    ];    

    /*start relationships*/

    public function loanproductsettings()
    {
        return $this->hasMany(LoanProductSetting::class, 'id', 'loan_limit_calculation_id');
    }

    public function loanproductsettingsaudits()
    {
        return $this->hasMany(LoanProductSettingsAudit::class, 'id', 'loan_limit_calculation_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    /*end relationships*/


    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {

        if (auth()->user()) {
            $user_id = auth()->user()->id;

            $attributes['created_by'] = $user_id;
            $attributes['updated_by'] = $user_id;
        }

        $model = static::query()->create($attributes);

        return $model;

    }

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function updatedata($id, array $attributes = [])
    { 

        //dd($attributes, $id);

        $user_id = auth()->user()->id;
        $attributes['updated_by'] = $user_id;
        

        //item data
        $item = static::query()->findOrFail($id);

        $model = $item->update($attributes);

        //start run item updated event
        event(new LoanProductSettingUpdated($item));
        //end run item updated event

        return $model;

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
