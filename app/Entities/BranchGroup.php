<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\CompanyBranch;
use App\Entities\GroupMember;
use App\Entities\Image;
use App\Entities\Status;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BranchGroup extends Model 
{

    protected $fillable = [
        'id', 'name', 'description', 'company_branch_id', 'company_id', 'physical_address', 
        'primary_user_id', 'box', 'phone', 'phone_country', 'email', 'status_id', 
        'created_by', 'updated_by'
    ];

    /*one to many relationship*/
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function companybranch() 
    {
        return $this->belongsTo(CompanyBranch::class, 'company_branch_id', 'id');
    }

    public function groupmembers()
    {
        return $this->hasMany(GroupMember::class);
    }

    public function primaryuser()
    {
        return $this->belongsTo(GroupMember::class, 'primary_user_id', 'id');
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

    public function status()
    {
        return $this->belongsTo(Status::class);
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
