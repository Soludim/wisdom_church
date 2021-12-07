<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

//this class keeps track of data counts that was added in day
class NewData extends Model
{
    public $fillable = [
        'date',
        'prayer_requests',
        'testimonies',
        'mail_received',
        'users'
    ];
}
