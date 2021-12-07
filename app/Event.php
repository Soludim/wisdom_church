<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Event extends Model
{
    protected $appends = ['standing'];
    protected $fillable =
    [
        'name',
        'coverImage',
        'details',
        'date',
        'time',
        'venue'
    ];

    public function getStandingAttribute() {
        $now = Carbon::now()->format('Y-m-d');
        $dt = Carbon::parse($now);
        return $now <= $this->date;//$dt->diffInDays('2020-05-25');
    }
}