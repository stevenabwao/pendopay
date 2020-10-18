<?php

namespace App\Entities;

use App\Entities\SmsType;
use App\Entities\Status;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Validator;

/**
 * Class ConfirmCode.
 */
class ConfirmCode extends Model
{

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id', 'email', 'phone', 'phone_country', 'confirm_code', 'sms_type_id', 'company_id', 'status_id'
    ];

    /**
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function create(array $attributes = [])
    {

        $model = static::query()->create($attributes);

        return $model;

    }

    /*relationships*/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function smstype()
    {
        return $this->belongsTo(SmsType::class);
    }

}
