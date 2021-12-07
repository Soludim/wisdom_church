<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
       'user_id',
       'liketable_id',
       'liketable_type'
    ];

    public function liketable() {
        return $this->morphTo();
    }
}
