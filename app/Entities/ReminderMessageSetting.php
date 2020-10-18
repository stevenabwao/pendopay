<?php

namespace App\Entities;

use App\Entities\Company; 
use App\Entities\Status;
use App\Entities\Term;
use App\Entities\LoanAccountAudit;
use App\Entities\Account;
use App\Entities\Product;
use App\Entities\ReminderMessageType;
use App\Entities\ReminderMessageTypeSection;
use App\Events\LoanAccountCreated;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReminderMessageSetting extends Model
{

    protected $table = "reminder_message_settings";
    
    /**
     * The attributes that are mass assignable
    **/
    protected $fillable = [
         'id', 'company_id', 'status_id', 'reminder_message_type_id', 'reminder_message_type_section_id', 'product_id', 
         'max_reminder_messages', 'reminder_message_send_to_expiry_cycle_id', 'reminder_message_send_to_expiry_value', 
         'reminder_message_send_repeat_schedule',
         'reminder_message_cycle_id', 'send_sms', 'send_email', 'created_at', 'created_by', 'updated_at', 'updated_by' 
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, "company_id", "id");
    }

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id", "id");
    }

    public function remindermessagecycle()
    {
        return $this->belongsTo(Term::class, "reminder_message_cycle_id", "id");
    }

    public function remindermessagesendtoexpirycycle()
    {
        return $this->belongsTo(Term::class, "reminder_message_send_to_expiry_cycle_id", "id");
    }

    public function remindermessagetype()
    {
        return $this->belongsTo(ReminderMessageType::class, "reminder_message_type_id", "id");
    }

    public function remindermessagetypesection()
    {
        return $this->belongsTo(ReminderMessageTypeSection::class, "reminder_message_type_section_id", "id");
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

        $user_id = auth()->user()->id;

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

        $user_id = auth()->user()->id;

        $attributes['updated_by'] = $user_id;

        //branch data
        $loanapplication = static::query()->findOrFail($id);

        //do any extra processing here

        $model = $loanapplication->update($attributes);

        return $model;

    }


}
