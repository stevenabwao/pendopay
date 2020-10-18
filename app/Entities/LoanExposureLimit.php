<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\CompanyUser;
use App\Entities\Status;
use App\Entities\LoanExposureLimitsAudit;
use App\Entities\LoanExposureLimitsDetail;
use App\Entities\LoanApplication;
use App\Events\LoanExposureLimitCreated;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoanExposureLimit extends Model
{

    /** 
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'user_id', 'company_user_id', 'company_id', 'limit', 'status_id', 'created_at', 'created_by',
         'updated_at', 'updated_by'
    ];

    /*model events*/
    protected $events = [
        'created' => LoanExposureLimitCreated::class,
    ];

    protected $table = "loan_exposure_limits";

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function companyuser()
    {
        return $this->belongsTo(CompanyUser::class, 'company_user_id', 'id');
    }

    public function loanexposurelimitsaudits()
    {
        return $this->hasMany(LoanExposureLimitsAudit::class, 'id', 'parent_id');
    }

    public function loanexposurelimitsdetails()
    {
        return $this->hasMany(LoanExposureLimitsDetail::class, 'id', 'loan_exposure_limit_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
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

        $user = auth()->user();
        $user_id = $user->id;

        $attributes['updated_by'] = $user_id;

        //item data
        $item = static::query()->findOrFail($id);

        //do any extra processing here
        $model = $item->update($attributes);

        return $model;

    }


}
