<?php

namespace App\Entities;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class OauthAccessToken.
 */
class OauthAccessToken extends Model
{

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

}
