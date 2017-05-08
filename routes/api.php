<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth.basic')->prefix('v1')->group(function () {
    // Route::resource('rooms','RoomController');
    Route::get('rooms','RoomController@allRooms');
    Route::get('rooms/{room}','RoomController@currentRoom');
    Route::get('rooms/{room}/{sensor}','RoomController@currentSensor');
    Route::get('/ledon','SwitcherController@on');
    Route::get('/ledoff','SwitcherController@off');
});
