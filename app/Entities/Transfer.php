<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\CompanyUser;
use App\Entities\Status;
use App\Entities\TransferAudit;
use App\Events\TransferCreated;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transfer extends Model
{

    /*model events*/
    protected $events = [
        'created' => TransferCreated::class,
    ]; 

    /**
     * The attributes that are mass assignable 
    **/
    protected $fillable = [
         'id', 'source_account_type', 'source_account_id', 'source_account_name', 'source_user_id', 'destination_user_id',
         'source_company_user_id', 'destination_company_user_id', 'source_phone', 'destination_phone', 
         'destination_account_type', 'destination_account_id', 'destination_account_name', 
         'amount', 'comments', 'status_id', 'company_id', 'source_account_no', 'destination_account_no',
         'created_at', 'created_by', 'updated_at', 'updated_by'
    ]; 


    public function sourceuser()
    {
        return $this->belongsTo(User::class, 'source_user_id', 'id');
    }

    public function destinationuser()
    {
        return $this->belongsTo(User::class, 'destination_user_id', 'id');
    }

    public function sourcecompanyuser()
    {
        return $this->belongsTo(CompanyUser::class, 'source_company_user_id', 'id');
    }

    public function destinationcompanyuser()
    {
        return $this->belongsTo(CompanyUser::class, 'destination_company_user_id', 'id');
    }

    public function transferaudits()
    {
        return $this->hasMany(TransferAudit::class); 
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

        //dd($attributes);
        $user_id = auth()->user()->id;

        $attributes['created_by'] = $user_id;
        $attributes['updated_by'] = $user_id;

        try{
            $model = static::query()->create($attributes);
        } catch (\Exception $e) {
            //dd($e);
        }
       

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

        $item = "";

        $item = static::query()->find($id);

        //if user is valid, proceed
        if ($item) {

            $attributes['updated_by'] = $user_id;

            //item data
            $item = static::query()->findOrFail($id);

            //do any extra processing here
            $model = $item->update($attributes);

            return $model;

        } else {

            abort(404);

        }

    }


}
