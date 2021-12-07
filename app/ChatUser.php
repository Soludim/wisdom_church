<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatUser extends Model
{
    protected $with = ['user'];
    protected $fillable = [
        'user_id',
        'chat_id'
    ];

    public function chat() {
        return $this->belongsTo('App\Chat')->select(['id', 'name', 'info']);
    }

    public function user() {
        return $this->belongsTo('App\User')->select(['id', 'name', 'email', 'initials', 'profile_pic', 'provider']);
    }

}