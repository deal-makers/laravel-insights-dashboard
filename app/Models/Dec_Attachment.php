<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Dec_Attachment extends Model
{
    protected $table = 'dec_attachments';
    protected $fillable = ['client_id', 'parent_id', 'mark_read', 'feedback'];

    public function detection()
    {
        return $this->belongsTo('App\Models\Detection');
    }
}

