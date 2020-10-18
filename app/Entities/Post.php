<?php

namespace App\Entities;

use App\Entities\Like;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
   
    protected $appends = ['liked_by_auth_user', 'user'];

    protected $fillable = [
        'content', 'ip', 'user_agent', 'user_id', 'wall_id'
    ];

    /*relation between objects and post*/
    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function images() {
        return $this->morphMany(Image::class, 'imagetable');
    }

    public function videos() {
        return $this->hasMany(Video::class);
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getUserAttribute()
    {
        $user_id = $this->user_id;
        $user = User::find($user_id);
        
        return $user;
    }

    public function getLikedByAuthUserAttribute()
    {
        $user_id = auth()->user()->id;
        $post_id = $this->id;

        $like = Like::where('user_id', $user_id)
                ->where('post_id', $post_id) 
                ->first();

        if ($like) {
            return true;
        }
        
        return false;
    }

}
