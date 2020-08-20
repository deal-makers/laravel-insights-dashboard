<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Detection extends Model
{
    protected $fillable = [
        'user_id', 'dec_id','title', 'type', 'emergency', 'detection_level', 'tlp', 'pap', 'client_send_ids', 'tags', 'comment', 'description', 'scenery', 'tech_detail',
        'reference', 'evidence', 'ioc', 'cves', 'cvss'];
}
