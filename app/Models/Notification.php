<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'id', 'creater_id', 'detection_id','detection_id', 'detection_type', 'send_clients', 'seen_users'];

}
