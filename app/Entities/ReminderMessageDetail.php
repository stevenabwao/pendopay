<?php

namespace App\Entities;

use App\Entities\Company; 
use App\Entities\Status;
use App\Entities\Term;
use App\Entities\LoanAccount;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReminderMessageDetail extends Model
{

    protected $table = "reminder_message_details";
    
    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'id', 'company_id', 'status_id', 'reminder_message_id', 'message', 
         'phone', 'email', 'reminder_message_category_id', 'loan_account_id',
         'created_at', 'created_by', 'updated_at', 'updated_by' 
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, "company_id", "id");
    }

    public function remindermessagetype()
    {
        return $this->belongsTo(Term::class, "reminder_message_type_id", "id");
    }

    public function loanaccount()
    {
        return $this->belongsTo(LoanAccount::class, "loan_account_id", "id");
    }

    public function remindermessagecategory()
    {
        return $this->belongsTo(Term::class, "message_category_id", "id");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
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

        $user = auth()->user();

        if ($user) {
            $user_id = auth()->user()->id;
        } else {
            $user_id = "-1";
        }

        $attributes['created_by'] = $user_id;
        $attributes['updated_by'] = $user_id;

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
            $user_id = auth()->user()->id;
        } else {
            $user_id = "-1";
        }

        $attributes['updated_by'] = $user_id;

        //branch data
        $loanapplication = static::query()->findOrFail($id);

        //do any extra processing here

        $model = $loanapplication->update($attributes);

        return $model;

    }


}
