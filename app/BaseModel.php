<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{

    // start getters
    public function getCreatedAtAttribute($value)
    {
        return showLocalizedDate($value);
    }

    public function getUpdatedAtAttribute($value)
    {
        return showLocalizedDate($value);
    }
    // end getters

    // start setters/ mutators
    /* public function setCreatedAtAttribute($date)
    {
        $this->attributes['created_at'] = formatUTCDate($date);
    }
    public function setUpdatedAtAttribute($date)
    {
        $this->attributes['updated_at'] = formatUTCDate($date);
    } */
    // end setters/ mutators

    // create
    public static function create(array $attributes = [])
    {

        if (isLoggedIn()) {

            $user = getLoggedUser();

            $attributes['created_by'] = $user->id;
            $attributes['created_by_name'] = $user->full_name;
            $attributes['updated_by'] = $user->id;
            $attributes['updated_by_name'] = $user->full_name;

        } else if   (
                        ($attributes['created_by']) ||
                        ($attributes['created_by_name']) ||
                        ($attributes['updated_by']) ||
                        ($attributes['updated_by_name'])
                    ) {

            $attributes['created_by'] = $attributes['created_by'] ? $attributes['created_by'] : "";
            $attributes['created_by_name'] = $attributes['created_by_name'] ? $attributes['created_by_name'] : "";
            $attributes['updated_by'] = $attributes['updated_by'] ? $attributes['updated_by'] : "";
            $attributes['updated_by_name'] = $attributes['updated_by_name'] ? $attributes['updated_by_name'] : "";

        }

    }

}
