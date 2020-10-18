<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\CompanyUser;
use App\Entities\Status;
use App\Entities\Currency;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RegistrationPayment extends Model
{

    /**
     * The attributes that are mass assignable 
    **/
    protected $fillable = [
         'id', 'amount', 'currency_id', 'company_user_id', 'user_id', 'company_id', 'payment_name', 
         'payment_phone', 'trans_id', 'created_at', 'updated_at'
    ]; 

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

    public function currency()
    {
        return $this->belongsTo(Currency::class);
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
        $user = auth()->user();

        if ($user) {

            $user_id = $user->id;

            $attributes['created_by'] = $user_id;
            $attributes['updated_by'] = $user_id;

        } else {

            $attributes['created_by'] = "-1";
            $attributes['updated_by'] = "-1";

        }

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

        if ($user) {

            $user_id = $user->id;

        } else {

            $user_id = "-1";

        }

        //$user_id = $user->id;

        //$loanapplication = "";

        /*
        if ($user->hasRole('superadministrator')) {
            //if user is superadmin, show
            $loanapplication = static::query()->find($id);
        } else if ($user->hasRole('administrator')){
            //if user is not superadmin, show only from user company
            $loanapplication = static::query()->where('company_id', $user->company->id)
                                ->where('id', $id)
                                ->first();
        }
        */

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
