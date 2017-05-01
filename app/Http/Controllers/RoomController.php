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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     protected $roomTransformer;
     protected $sensorTransformer;

     function __construct(RoomTransformer $roomTransformer, SensorTransformer $sensorTransformer)
     {
         $this->roomTransformer = $roomTransformer;
         $this->sensorTransformer = $sensorTransformer;
     }

    public function index()
    {
        $limit = Input::get('limit') ?: 1;
        $rooms = Room::paginate($limit);
        return $this->respondWithPagination($rooms, [
            'data' => $this->roomTransformer->transformCollection($rooms->all()),
        ]);
    }    

    /**
     * Display the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show($roomName)
    {
        $limit = Input::get('limit') ?: $this->sensorLimit;

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

    public function sensors($roomName, $sensorName)
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

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit($roomName)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        //
    }
}
