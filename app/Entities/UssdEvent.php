<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\UssdEventMap;
use App\Entities\Status;
use App\Entities\UssdPayment;
use App\Entities\UssdRegistration;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UssdEvent extends Model
{

    
    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
        'name', 'company_id', 'description', 'amount', 'ussd_event_map_id', 'status_id', 'start_at', 'end_at'
    ];
    

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
    */
    protected $dates = ['start_at', 'end_at'];


    /*relationships*/
    public function company() {
        return $this->belongsTo(Company::class);
    }
    

    public function ussdpayments() {
        return $this->hasMany(UssdPayment::class);
    }

    public function ussdeventmap() {
        return $this->hasOne(UssdEventMap::class, 'ussd_event_map_id', 'id');
    }


    public function status() {
        return $this->belongsTo(Status::class);
    }


    public function ussdregistrations() {
        return $this->hasMany(UssdRegistration::class);
    }


    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {

        $user = auth()->user();
        $user_id = $user->id;

        $start_at = $attributes['start_at'];
        $end_at = $attributes['end_at'];

        if (array_key_exists('start_at', $attributes)) {
            $start_at = Carbon::parse($start_at);
            $attributes['start_at'] = $start_at;
        }

        if (array_key_exists('end_at', $attributes)) {
            $end_at = Carbon::parse($end_at);
            $end_at = $end_at->addDay();
            $end_at = $end_at->subMinute();
            $attributes['end_at'] = $end_at;
        }

        $model = static::query()->create($attributes);

        //create new associated event map
        $new_ussd_event_map = new UssdEventMap();

            $new_ussd_event_map->ussd_event_id = $model->id; 
            $new_ussd_event_map->ussd_event_type_id = $attributes['ussd_event_type_id']; 
            $new_ussd_event_map->created_by = $user_id;   
            $new_ussd_event_map->updated_by = $user_id;
            $new_ussd_event_map->required = 0;
            
        $new_ussd_event_map->save();


        //update ussd_event_map_id
        $new_attributes['ussd_event_map_id'] = $new_ussd_event_map->id;
        
        $model = $model->update($new_attributes);

        //start update last deposit amount and data for account number
        // $model = static::query()->where('acct_no', $acct_no)
        // ->update([
        //             'last_deposit_amt' => $amount,
        //             'last_deposit_dt' => $date,
        //             'avg_bal_dt' => $date,
        //             'last_activity_dt' => $date,
        //             'ledger_bal' => $current_ledger_bal + $amount,
        //             'cleared_bal' => $current_cleared_bal + $amount,
        //             'cr_count' => $current_cr_count + 1,
        //             'version_no' => $current_version_no + 1,
        //             'user_id' => $main_user_id
        //         ]);

        return $model;

    }
    

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function updatedata($id, array $attributes = [])
    {

        //dd($attributes);
        $item = static::query()->findOrFail($id);

        $user = auth()->user();
        $user_id = $user->id;

        $attributes['updated_by'] = $user_id;

        $start_at = $attributes['start_at'];
        $end_at = $attributes['end_at'];

        if (array_key_exists('start_at', $attributes)) {
            $start_at = Carbon::parse($start_at);
            $attributes['start_at'] = $start_at;
        }

        if (array_key_exists('end_at', $attributes)) {
            $end_at = Carbon::parse($end_at);
            $end_at = $end_at->addDay();
            $end_at = $end_at->subMinute();
            $attributes['end_at'] = $end_at;
        }

        //get associated event map
        $ussd_event_map = UssdEventMap::where('ussd_event_id', $id)
            ->first();

        //is ussd_event_map has changed, edit it, otherwise skip
        if ((count($ussd_event_map)) && ($ussd_event_map->ussd_event_type_id != $attributes['ussd_event_type_id'])) {
            
            //delete existing map and create a new one
            UssdEventMap::destroy($ussd_event_map->id);

            //create a new map
            $new_ussd_event_map = new UssdEventMap();

                $new_ussd_event_map->ussd_event_id = $id; 
                $new_ussd_event_map->ussd_event_type_id = $attributes['ussd_event_type_id']; 
                $new_ussd_event_map->created_by = $user_id;   
                $new_ussd_event_map->updated_by = $user_id;
                $new_ussd_event_map->required = 0;
                
            $new_ussd_event_map->save();

            $attributes['ussd_event_map_id'] = $new_ussd_event_map->id;

        }


        //if mapping does not exist, create one
        if (!count($ussd_event_map)) {
            
            $new_ussd_event_map = new UssdEventMap();

            $new_ussd_event_map->ussd_event_id = $item->id; 
            $new_ussd_event_map->ussd_event_type_id = $attributes['ussd_event_type_id']; 
            $new_ussd_event_map->created_by = $user_id;   
            $new_ussd_event_map->updated_by = $user_id;
            $new_ussd_event_map->required = 0;
            
            $new_ussd_event_map->save();


            //update ussd_event_map_id
            $new_attributes['ussd_event_map_id'] = $new_ussd_event_map->id;
            
            $item->update($new_attributes);

        }

        //dd($attributes, $ussd_event_map, $new_ussd_event_map);
        //dd($attributes);

        //do any extra processing here

        $model = $item->update($attributes);

        return $model;

    }


    //start convert dates to local dates
    /*public function setStartAtAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function setEndAtAttribute($value)
    {
        return Carbon::parse($value)->addDay()->subMinute();
    }*/


    public function getStartAtAttribute($value)
    {
        return Carbon::parse($value);
    }

    public function getEndAtAttribute($value)
    {
        return Carbon::parse($value);
    }

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
