<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Injury extends Model
{
    //
    protected $table = "injuries";
    protected $fillable = ['player_id', 'injury', 'injury_date', 'description'];

    public function player()
    {
        return $this->belongsTo('App\Models\User\Player');
    }
}
