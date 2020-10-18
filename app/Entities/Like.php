<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    
    protected $fillable = [
        'post_id', 'ip', 'user_agent', 'user_id',
    ];

    public function post() {
        return $this->belongsTo(Post::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

}
