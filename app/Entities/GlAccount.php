<?php

namespace App\Entities;

use App\Entities\Status;
use App\Entities\Company;
use App\Entities\GlAccountType;
use App\Entities\GlAccountHistory;
use App\Entities\GlAccountSummary;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class GlAccount extends Model
{

    //use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'id', 'gl_account_type_id', 'gl_account_no', 'gl_account_sequence',
         'description', 'company_id', 'status_id', 'created_at',
         'created_by', 'updated_at', 'updated_by', 'deleted_at', 'deleted_by'
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
        //class, foreign key, local key
    }

    public function glaccounttype()
    {
        return $this->belongsTo(GlAccountType::class, 'gl_account_type_id', 'id');
    }

    public function glaccountsummary()
    {
        return $this->hasOne(GlAccountSummary::class, 'gl_account_no', 'gl_account_no');
        //class, foreign key, local key
    }

    public function glaccounthistories()
    {
        return $this->hasMany(GlAccountHistory::class, 'gl_account_no', 'gl_account_no');
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
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }

    public function getDeletedAtAttribute($value)
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

        try {
            $user_id = auth()->user()->id;
            //$user_id = '1';

            $attributes['created_by'] = $user_id;
            $attributes['updated_by'] = $user_id;

            $model = static::query()->create($attributes);
        } catch(\Exception $e) {
            dd($e);
        }

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
