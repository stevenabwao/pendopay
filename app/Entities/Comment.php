<?php

namespace App\Entities;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    
    protected $appends = ['user'];

    protected $fillable = [
        'content', 'ip', 'user_agent', 'user_id', 'post_id'
    ];

    /*
    relation between comment and post*/
    public function post() {
        return $this->belongsTo(Post::class);
    }

    /*
    relation between comment and user*/
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getUserAttribute()
    {
        $user_id = $this->user_id;
        $user = User::find($user_id);
        
        return $user;
    }
    
}
