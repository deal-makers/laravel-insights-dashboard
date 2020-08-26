<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'client_id', 'detection_id', 'contact_reason', 'contents'];

    public function detection()
    {
        return $this->belongsTo('App\Models\Detection');
    }
}
