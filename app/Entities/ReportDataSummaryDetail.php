<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\Status;
use App\User;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReportDataSummaryDetail extends Model
{

    protected $dates = ['last_updated_at'];

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'id', 'payment_id', 'company_user_id', 'parent_id', 'data_parent_id', 'mpesa_code',
         'amount', 'currency_id', 'section', 'trans_ref_txt', 'trans_desc', 'status_id', 'company_product_id',
         'company_id', 'created_by', 'updated_by', 'created_at', 'updated_at'
    ];

    protected $table = "report_data_summary_details";

    //start relatonships
    public function user()
    {
        return $this->belongsTo(User::class);
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
    //end relatonships

    //start convert dates to local dates
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }


    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->timezone(getLocalTimezone());
    }

    public function getLastUpdatedAtAttribute($value)
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

        $user = auth()->user();

        if ($user) {
            $attributes['created_by'] = $user->id;
            $attributes['updated_by'] = $user->id;
        } else {
            $attributes['created_by'] = "1";
            $attributes['updated_by'] = "1";
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

        $user = auth()->user();

        if ($user) {
            $attributes['updated_by'] = $user->id;
        } else {
            $attributes['updated_by'] = "1";
        }

        //branch data
        $item = static::query()->findOrFail($id);

        //do any extra processing here

        $model = $item->update($attributes);

        return $model;

    }


}
