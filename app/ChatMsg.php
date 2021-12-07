<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatMsg extends Model
{
    protected $fillable = [
        'msg',
        'user_id',
        'chat_id'
    ];

    public function chat() {
        return $this->belongsTo('App\Chat');
    }

    public function user() {
        return $this->belongsTo('App\User')->select(['id', 'name', 'email', 'initials', 'profile_pic']);
    }
}