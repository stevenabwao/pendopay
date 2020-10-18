<?php

namespace App\Entities;

use App\Entities\Company;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UserAccountInquiry extends Model
{

    protected $table = 'user_account_inquiries';

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'id', 'user_id', 'first_name', 'last_name',  'company_id', 'phone', 'src_ip', 'user_agent', 
        'browser', 'browser_version', 'os', 'device', 'created_by', 'updated_by'
    ];

    /*relationships*/
    public function company()
    {
        return $this->belongsTo(Company::class);
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

        if (array_key_exists('sms_user_name', $attributes)) {
            $sms_user_name = $attributes['sms_user_name'];
            //remove all special chars
            $attributes['sms_user_name'] = removeSpecialChars($sms_user_name);
        }

        //item data
        $item = static::query()->findOrFail($id);

        $model = $item->update($attributes);

        return $model;

    }

}
