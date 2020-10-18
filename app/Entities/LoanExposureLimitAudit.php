<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\CompanyUser;
use App\Entities\Status;
use App\Entities\LoanExposureLimit;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoanExposureLimitAudit extends Model
{

    protected $table = "loan_exposure_limits_audits";

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
        'parent_id', 'user_id', 'company_user_id', 'company_id', 'limit', 'status_id', 'created_at', 'created_by',
        'comments', 'updated_at', 'updated_by'
    ];

    /*start relationships*/

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function companyuser()
    {
        return $this->belongsTo(CompanyUser::class, 'company_user_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function loanexposurelimit()
    {
        return $this->belongsTo(LoanExposureLimit::class, 'parent_id', 'id');
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
        }

        //add parent id
        $attributes['parent_id'] = $attributes['id'];

        //remove id and updated_by fields from array, 
        //id will be auto populated (autoincrement field)
        unset($attributes['id']);

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

        //dd($model, $attributes);

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
