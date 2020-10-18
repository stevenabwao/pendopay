<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    
    public function post() {
        return $this->belongsTo(Post::class);
    }
    
}
