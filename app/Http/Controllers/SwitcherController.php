<?php

namespace App\Http\Controllers;

use App\Sensor;
use App\Room;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Facades\Input;

class SwitcherController extends ApiController
{
    public function on()
    {
        // $fp = fopen($port, "w");
        // sleep(1);
        // fputs($fp, "ledon");
        // fclose($fp);
        return $this->respondSuccess('Turned on!');
    }

    public function off()
    {
        // $fp = fopen($port, "w");
        // sleep(1);
        // fputs($fp, "ledoff");
        // fclose($fp);
        return $this->respondSuccess('Turned off!');
    }
}
