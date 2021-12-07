<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Sermon extends Model
{
    protected $fillable = [
        'topic',
        'content',
        'video_url',
        'speaker_name',
        'speaker_image',
        'speaker_position',
        'coverImage',
    ];


    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable');
    }

}
