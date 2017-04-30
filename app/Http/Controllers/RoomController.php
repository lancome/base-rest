<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Transformers\RoomTransformer;
use App\Http\Transformers\SensorTransformer;
use Illuminate\Contracts\Support\Jsonable;

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
        $rooms = Room::all();
        return response()->json([
            'data' => $this->roomTransformer->transformCollection($rooms->toArray())
        ], 200);

        // $rooms = Room::paginate(2);
        // return response()->json([
        //     'data' => $rooms
        // ], 200);
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
     * Display the specified resource.
     *
     * @param  \App\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show($roomName)
    {
        $room = Room::findByName($roomName);
        if(!$room) {
            return $this->respondNotFound('Room does not exists');
        }
        $sensors = $room->sensors()->get();
        return response()->json([
            'data' => $this->sensorTransformer->transformCollection($sensors->toArray())
        ], 200);
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


    public function sensors($roomName, $sensorName)
    {
        $room = Room::findByName($roomName);
        if(!$room) {
            return $this->respondNotFound('Room does not exists');
        }

        $sensors = $room->sensors()->where('name', $sensorName)->get();
        if($sensors->isEmpty()) {
            return $this->respondNotFound('Sensor does not exists');
        }
        
        return response()->json([
            'data' => $this->sensorTransformer->transformCollection($sensors->toArray())
        ], 200);
    }
}
