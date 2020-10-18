<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\CompanyProduct;
use App\Entities\LoanProductSetting;
use App\Entities\Term;
use App\Entities\LoanLimitCalculation;
use App\User;
use Carbon\Carbon;
use Dingo\Api\Exception\StoreResourceFailedException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LoanProductSettingsAudit extends Model
{

    protected $table = "loan_product_settings_audits";

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [

        'id', 'parent_id', 'loan_product_status', 'loans_exceeding_limit', 'loan_approval_method', 'company_product_id',
        'company_id', 'interest_type', 'interest_amount', 'interest_method', 'max_simultaneous_loans', 
        'max_loan_applications_per_day', 'min_loan_limit', 'initial_loan_limit',
        'interest_cycle', 'loan_instalment_cycle', 'loan_instalment_period', 'max_loan_limit', 
        'one_month_limit', 'one_to_three_month_limit', 'three_to_six_month_limit', 'above_six_month_limit',
        'initial_exposure_limit', 'increase_exposure_limit', 'decrease_exposure_limit', 'borrow_criteria', 
        'minimum_contributions', 'loan_limit_calculation_id', 'minimum_contributions_condition_id', 'created_by', 
        'updated_by', 'created_at', 'updated_at', 'status_id'
    ];

    /*start relationships*/

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function loanproductsetting()
    {
        return $this->belongsTo(LoanProductSetting::class, 'parent_id', 'id');
    }

    public function companyproduct()
    {
        return $this->belongsTo(CompanyProduct::class, 'company_product_id', 'id');
    }

    public function loanlimitcalculation()
    {
        return $this->belongsTo(LoanLimitCalculation::class, 'loan_limit_calculation_id', 'id');
    }

    public function interestcyle()
    {
        return $this->belongsTo(Term::class, 'interest_cycle', 'id');
    }

    public function loaninstalmentcyle()
    {
        return $this->belongsTo(Term::class, 'loan_instalment_cycle', 'id');
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
