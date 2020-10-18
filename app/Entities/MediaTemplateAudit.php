<?php

namespace App\Entities;

use App\Entities\Company;
use App\Entities\Status;
use App\User;
use Illuminate\Database\Eloquent\Model;

class MediaTemplateAudit extends Model
{

    /**
     * The attributes that are mass assignable
     */
    protected $fillable = [
        'id', 'parent_id', 'name', 'text', 'default_text', 'company_id', 'media_type', 'site_function',
        'status_id', 'created_by', 'created_by_name', 'updated_by', 'updated_by_name'
    ];

    /*relationships*/
    public function mediatemplate()
    {
        return $this->belongsTo(MediaTemplate::class, 'parent_id', 'id');
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
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    //start convert dates to local dates
    public function getCreatedAtAttribute($value)
    {
        return showLocalizedDate($value);
    }

    public function getUpdatedAtAttribute($value)
    {
        return showLocalizedDate($value);
    }
    //end convert dates to local dates

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

        if (auth()->user()) {
            $user_id = auth()->user()->id;

            $attributes['updated_by'] = $user_id;
        }

        //item data
        $item = static::query()->findOrFail($id);

        $model = $item->update($attributes);

        return $model;

    }

}
