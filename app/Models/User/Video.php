<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    //
    protected $table = "videos";
    protected $fillable = ['player_id', 'main_video', 'another_video'];
    //
    public function player()
    {
        return $this->belongsTo('App\Models\User\Player');
    }
}
