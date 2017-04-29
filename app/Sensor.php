<?php

namespace App;

use App\Room;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    protected $fillable = [
        'name',
        'result',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
