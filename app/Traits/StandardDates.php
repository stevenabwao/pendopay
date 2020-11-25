<?php

namespace App\Traits;

trait StandardDates
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

}
