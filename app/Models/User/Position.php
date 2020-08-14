<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    public function player()
    {
        return $this->belongsTo('App\Models\User\Player');
    }
}
