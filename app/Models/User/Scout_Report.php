<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Scout_Report extends Model
{
    protected $table = "scout_reports";
    protected $fillable = ['player_id', 'general_info', 'strengths', 'weaknesses', 'pros', 'cons', 'conclusion', 'other'];

    public function player()
    {
        return $this->belongsTo('App\Models\User\Player');
    }
    //
}
