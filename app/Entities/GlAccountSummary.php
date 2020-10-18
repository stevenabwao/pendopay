<?php

namespace App\Entities;

use App\BaseModel;
use App\Entities\Status;
use App\Entities\Company;
use App\Entities\Currency;
use App\Entities\GlAccount;
use App\User;
use Carbon\Carbon;

class GlAccountSummary extends BaseModel
{

    protected $dates = ['last_activity_date'];

    protected $table = "gl_account_summary";

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'id', 'gl_account_no', 'currency_id', 'ledger_balance',
         'cleared_balance', 'last_activity_date', 'company_id', 'status_id', 'created_at',
         'created_by', 'updated_at', 'updated_by', 'created_by_name', 'updated_by_name'
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function glaccount()
    {
        return $this->belongsTo(GlAccount::class, 'gl_account_no', 'gl_account_no');
        //class, foreign key, local key
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

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id');
    }


    //start convert dates to local dates
    public function getLastActivityDateAttribute($value)
    {
        return showLocalizedDate($value);
    }
    //end convert dates to local dates

    // start setters/ mutators
    public function setLastActivityDateAttribute($date)
    {
        $this->attributes['last_activity_date'] = formatUTCDate($date);
    }
    // end setters/ mutators


    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {

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
