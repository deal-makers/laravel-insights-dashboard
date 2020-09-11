<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lang extends Model
{
    protected $fillable = ['user_id', 'lang'];

    public function user()
    {
        $this->belongsTo('App\User' );
    }
}
