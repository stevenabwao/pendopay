<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\CompanyUser;
use App\Entities\SupervisorClientAssignDetail;
use App\Entities\SupervisorClientAssignAudit;
use App\Entities\Status;
use App\User;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SupervisorClientAssign extends Model
{


    protected $table = "supervisor_client_assign";

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'id', 'company_supervisor_id', 'company_id', 'created_by', 'updated_by', 
         'created_by_name', 'updated_at', 'created_at', 'updated_by_name', 'number_clients'
    ];

    /*start relationships*/
    public function supervisorclientassigndetails()
    {
        return $this->hasMany(SupervisorClientAssignDetail::class);
    }

    public function supervisorclientassignhistorys()
    {
        return $this->hasMany(SupervisorClientAssignAudit::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function supervisoruser()
    {
        return $this->belongsTo(CompanyUser::class, 'company_supervisor_id', 'id');
    }

    public function status()
    {
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
    

    /*end relationships*/

    //start convert dates to local dates
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }

    public function getSentAtAttribute($value)
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

        //dd($attributes);
        
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

        if (auth()->user()) {
            $user_id = auth()->user()->id;

            $attributes['updated_by'] = $user_id;
        }

        //item data
        $item = static::query()->findOrFail($id);

        $model = $item->update($attributes);

        return $model;

    }


}
