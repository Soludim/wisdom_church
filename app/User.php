<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
        'lives_in', 'contact', 'profile_pic', 'role_id', 'api_token',
        'initials', 'provider', 'provider_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function chats()
    {
        return $this->belongsToMany('App\Chat');
    }

    public function chatMsgs()
    {
        return $this->hasMany('App\ChatMsg');
    }

    public function chatUser()
    {
        return $this->hasMany('App\ChatUser');
    }

    public function testimonies()
    {
        return $this->hasMany('App\Testimony');
    }

    public function role()
    {
        return $this->belongsTo('App\Role')->select(['id', 'name']);
    }

    public function sermons()
    {
        return $this->hasMany('App\Sermon');
    }

    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function replies()
    {
        return $this->hasMany('App\User');
    }
}
