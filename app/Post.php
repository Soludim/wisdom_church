<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    protected $fillable = [
        'title',
        'content',
        'user_id',
        'coverImage',
        'category_id'
    ];

    public function user() {
        return $this->belongsTo('App\User')->select(['id','name', 'initials', 'profile_pic', 'email']);
    }

    public function comments() {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function category() {
        return $this->belongsTo('App\PostCategory')->select(['id', 'name']);
    }

}
