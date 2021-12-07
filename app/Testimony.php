<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Testimony extends Model
{
    protected $fillable = [
        'content',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo('App\User')->select(['id','name', 'profile_pic']);
    }
}
