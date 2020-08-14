<?php

namespace App\Models\User;

use App\Models\User\Position;
use App\Models\User\Parameter;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public function positions()
    {
        return $this->hasMany('App\Models\User\Position');
    }

    public function parameters()
    {
        return $this->hasMany('App\Models\User\Parameter');
    }

    public function latestParam()
    {
        return $this->hasOne('\App\Models\User\Parameter')->latest();
    }

    public function additional()
    {
        return $this->hasOne('\App\Models\User\Additional');
    }

    public function storePositions($positions)
    {
        $this->positions()->delete();
        $arr_data = array();
        foreach ($positions as $position) {
            $data = new Position();
            $data->position = $position['position'];
            $data->specify = $position['specify'];
            array_push($arr_data, $data);
        }
        if (sizeof($arr_data) > 0)
            $this->positions()->saveMany($arr_data);
    }

    public function storeParameters($parameters)
    {
        $parameter = new Parameter();
        $keys = array_keys($parameters);

        foreach ($keys as $key) {
            $parameter->$key = $parameters[$key];
        }

        $this->parameters()->save($parameter);
    }

    public function scout_report()
    {
        return $this->hasOne('\App\Models\User\Scout_Report');
    }
    public function injury()
    {
        return $this->hasMany('\App\Models\User\Injury');
    }
    public function video()
    {
        return $this->hasOne('\App\Models\User\Video');
    }
}
