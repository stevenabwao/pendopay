<?php

namespace App\Entities;

use App\Entities\ConfirmCode;
use Illuminate\Database\Eloquent\Model;

class SmsType extends Model
{
    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'id', 'name', 'description'
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
    public function confirmcodes()
    {
        return $this->hasMany(ConfirmCode::class);
    }
}
