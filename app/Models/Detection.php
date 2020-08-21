<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Detection extends Model
{
    protected $fillable = [
        'user_id', 'dec_id','title', 'type', 'emergency', 'detection_level', 'tlp', 'pap', 'client_send_ids', 'tags', 'comment', 'description', 'scenery', 'tech_detail',
        'reference', 'evidence', 'ioc', 'cves', 'cvss'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
