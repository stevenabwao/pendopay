<?php

namespace App\Traits;

use App\Role;

trait CheckHasRoles
{

    /**
     * check if user has this role
     *
     */
    public function hasRole($role)
    {

        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        // no role exists
        return false;

    }

    /**
     * check if user has any of these roles
     *
     */
    public function hasAnyRole($roles)
    {

        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            // one role passed in (not array)
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        // no role exists
        return false;

    }

}
