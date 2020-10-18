<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\DepositAccount;
use App\Entities\Group;
use App\Entities\CompanyProduct;
use App\Entities\CompanyUser;
use App\Entities\Status;
use App\Entities\Term;
use App\Entities\Currency;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoanApplicationDecline extends Model
{

    protected $table = "loan_application_declined";
    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'user_id', 'company_user_id', 'company_id', 'group_id', 'deposit_account_id', 'deposit_account_no', 
         'interest_type', 'interest_amount', 'interest_method', 'currency_id', 'loan_amt', 
         'comments', 'currency_id', 'status_id', 'term_id', 'term_value', 
         'created_at', 'created_by', 'updated_at', 'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function companyuser()
    {
        return $this->belongsTo(CompanyUser::class, 'company_user_id', 'id');
    }

    public function depositaccount()
    {
        return $this->belongsTo(DepositAccount::class, 'deposit_account_id', 'id');
    }

    public function term()
    {
        return $this->belongsTo(Term::class); 
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
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
            return $model;
        } catch (\Exception $e) {
            //dd($e);
        }
       
    }

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function updatedata($id, array $attributes = [])
    {

        $user = auth()->user();
        $user_id = $user->id;

        $loanapplication = "";

        if ($user->hasRole('superadministrator')) {
            //if user is superadmin, show
            $loanapplication = static::query()->find($id);
        } else if ($user->hasRole('administrator')){
            //if user is not superadmin, show only from user company
            $loanapplication = static::query()->where('company_id', $user->company->id)
                                ->where('id', $id)
                                ->first();
        }

        //if user is valid, proceed
        if ($loanapplication) {

            $attributes['updated_by'] = $user_id;

            //loanapplication data
            $loanapplication = static::query()->findOrFail($id);

            //do any extra processing here
            $model = $loanapplication->update($attributes);

            return $model;

        } else {

            abort(404);

        }

    }


}
