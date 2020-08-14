<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class ApiTeam extends Model
{
    //
    public function league()
    {
        return $this->getAttribute("competition_name");
    }
}
