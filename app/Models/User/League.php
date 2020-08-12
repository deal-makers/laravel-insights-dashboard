<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    //
    protected $fillable = ['name', 'user_id'];

    public function teams()
    {
        return $this->hasMany('App\Models\User\Team');
    }
}
