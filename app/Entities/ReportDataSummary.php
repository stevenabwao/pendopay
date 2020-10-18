<?php

namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReportDataSummary extends Model
{

    protected $dates = ['last_updated_at', 'report_at'];

    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'id', 'day', 'day_name', 'month', 'month_name', 'year', 'total', 'section', 'company_product_id',
         'count', 'company_id', 'last_updated_at', 'created_at', 'updated_at', 'report_at'
    ];

    protected $table = "report_data_summaries";

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
