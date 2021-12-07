<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'name',
        'info',
        'user_id'        //the creater of the chat
    ];

    public function users() {
        return $this->hasMany('App\User')->select(['id', 'name', 'email', 'initials', 'profile_pic', 'provider']);
    }

    public function chatMsgs() {
        return $this->hasMany('App\ChatMsg')->select(['id', 'user_id', 'chat_id', 'msg', 'created_at']);
    }

    public function chatUsers() {
        return $this->hasMany('App\ChatUser')->select(['id', 'user_id', 'chat_id']);
    }

}
