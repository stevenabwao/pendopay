<?php

namespace App\Entities;

use App\BaseModel;
use App\Entities\Status;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

Relation::morphMap([
	'userimage' => 'App\User',
    'companyimage' => 'App\Entities\Company',
    'offerimage' => 'App\Entities\Offer',
    'productimage' => 'App\Entities\Product'
]);

class Image extends BaseModel
{

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id', 'caption', 'thumb_img', 'thumb_img_400', 'full_img', 'status_id', 'image_section',
        'imagetable_id', 'imagetable_type', 'created_by', 'updated_by', 'category_id','main_img'
    ];

    /*polymorphic relationship*/
    public function imagetable() {
        return $this->morphTo();
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

    public function getAllAttributes()
    {

        $columns = $this->getFillable();

        $attributes = $this->getAttributes();

        foreach ($columns as $column)
        {
            if (!array_key_exists($column, $attributes))
            {
                $attributes[$column] = null;
            }

            if (!array_key_exists('thumb_img_400', $attributes))
            {
                //dd('no thumb_img_400 exists');
            }
        }
        return $attributes;
    }

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

        //item data
        $item = static::query()->findOrFail($id);

        $model = $item->update($attributes);

        return $model;

    }

}
