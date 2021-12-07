<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    protected $withCount = ['likes'];
    protected $with = ['likes'];

    protected $appends = ['liked_by_auth_user'];

    protected $fillable = [
        'body',
        'commentable_id',
        'commentable_type',
        'user_id'
    ];

    public function commentable() {
        return $this->morphTo();
    }

    public function replies() {
        return $this->hasMany('App\Reply');
    }

    public function likes() {
        return $this->morphMany('App\Like', 'liketable');
    }

    public function getLikedByAuthUserAttribute() {
        
        if (Auth::guard('api')->user()) {
            $like = $this->likes()->whereUserId(Auth::guard('api')->user()->id)->first();
            return (!is_null($like)) ? $like->id : null;
        } else {
            return null;
        }
    }

    public function user() {
        return $this->belongsTo('App\User')->select(['id', 'name', 'profile_pic']);
    }
}