<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\CompanyBranch;
use App\Entities\CompanyBranchUser;
use App\Entities\BranchGroup;
use App\Entities\Status;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CompanyBranchUserGroup extends Model
{

    /**
     * The attributes that are mass assignable 
     */
    protected $fillable = [
        'id', 'company_branch_user_id', 'branch_group_id', 'company_id', 'user_id', 'created_by', 
        'status_id', 'updated_by', 'created_at', 'updated_at'
    ];

    public function companybranchuser()
    {
        return $this->belongsTo(CompanyBranchUser::class, "company_branch_user_id", "id");
    }

    public function branchgroup()
    {
        return $this->belongsTo(BranchGroup::class, "branch_group_id", "id");
    }

    public function company()
    {
        return $this->belongsTo(Company::class, "company_id", "id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id"); 
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public static function getUser()
    {
        $user_id = auth()->user();
        $userCompany = User::where('id', auth()->user()->id)->with('company')->first();
        return $userCompany;
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
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

        $user_id = auth()->user()->id;
        $attributes['updated_by'] = $user_id;

        //user data
        $user = static::query()->findOrFail($id);

        $model = $user->update($attributes);

        return $model;

    }


}
