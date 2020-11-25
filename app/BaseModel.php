<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{

    // start getters
    public static function getCreatedAtAttribute($value)
    {
        return showLocalizedDate($value);
    }

    public static function getUpdatedAtAttribute($value)
    {
        return showLocalizedDate($value);
    }
    // end getters

    // create
    public static function create(array $attributes = [])
    {

        if (isLoggedIn()) {

            $user = getLoggedUser();

            $created_by = $user->id;
            $created_by_name = $user->full_name;
            $updated_by = $user->id;
            $updated_by_name = $user->full_name;

        } else if   (
                        ($attributes['created_by']) ||
                        ($attributes['created_by_name']) ||
                        ($attributes['updated_by']) ||
                        ($attributes['updated_by_name'])
                    ) {

            $created_by = $attributes['created_by'] ? $attributes['created_by'] : "";
            $created_by_name = $attributes['created_by_name'] ? $attributes['created_by_name'] : "";
            $updated_by = $attributes['updated_by'] ? $attributes['updated_by'] : "";
            $updated_by_name = $attributes['updated_by_name'] ? $attributes['updated_by_name'] : "";

        } else {

            $created_by = NULL;
            $created_by_name = "";
            $updated_by = NULL;
            $updated_by_name = "";

        }

        $attributes['created_by'] = $created_by;
        $attributes['created_by_name'] = $created_by_name;
        $attributes['updated_by'] = $updated_by;
        $attributes['updated_by_name'] = $updated_by_name;

    }

    // update
    public static function updatedata($id, array $attributes = [])
    {

        if (isLoggedIn()) {

            $user = getLoggedUser();

            $attributes['updated_by'] = $user->id;
            $attributes['updated_by_name'] = $user->full_name;

        } else if   (
                        ($attributes['updated_by']) ||
                        ($attributes['updated_by_name'])
                    ) {

            $attributes['updated_by'] = $attributes['updated_by'] ? $attributes['updated_by'] : "";
            $attributes['updated_by_name'] = $attributes['updated_by_name'] ? $attributes['updated_by_name'] : "";

        }

    }

}
