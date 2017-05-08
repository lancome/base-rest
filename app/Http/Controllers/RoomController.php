<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Transformers\RoomTransformer;
use App\Http\Transformers\SensorTransformer;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Facades\Input;

class RoomController extends ApiController
{
     protected $roomTransformer;
     protected $sensorTransformer;

     function __construct(RoomTransformer $roomTransformer, SensorTransformer $sensorTransformer)
     {
         $this->roomTransformer = $roomTransformer;
         $this->sensorTransformer = $sensorTransformer;
     }

    public function allRooms()
    {
        $limit = Input::get('limit') ?: 10;
        $rooms = Room::paginate($limit);
        return $this->respondWithPagination($rooms, [
            'data' => $this->roomTransformer->transformCollection($rooms->all()),
        ]);
    }    

    public function currentRoom($roomName)
    {
        $limit = Input::get('limit') ?: ($this->sensorLimit * $this->sensors);

        $room = Room::findByName($roomName);
        if(!$room) {
            return $this->respondNotFound('Room does not exists');
        }
        if($limit>$this->sensorLimit*$this->sensors)
        {
            return $this->respondWrongRange('Requested range not satisfiable');
        }
        $sensors = $room->sensors()->paginate((int)$limit);
        return $this->respondWithPagination($sensors, [
            'data' => $this->sensorTransformer->transformCollection($sensors->all())
        ]);
    }

    public function currentSensor($roomName, $sensorName)
    {
        $limit = Input::get('limit') ?: $this->sensorLimit;
        $room = Room::findByName($roomName);

        if(!$room) {
            return $this->respondNotFound('Room does not exists');
        }

        if($limit>$this->sensorLimit)
        {
            return $this->respondWrongRange('Requested range not satisfiable');
        }

        $sensors = $room->sensors()->where('name', $sensorName)->paginate((int)$limit);
        if($sensors->isEmpty()) {
            return $this->respondNotFound('Sensor does not exists');
        }
        
        return $this->respondWithPagination($sensors, [
            'data' => $this->sensorTransformer->transformCollection($sensors->all())
        ]);
    }
}
