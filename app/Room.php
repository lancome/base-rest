<?php

namespace App;

use App\User;
use App\Sensor;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sensors()
    {
        return $this->hasMany(Sensor::class);
    }

    public static function findByName($id)
    {
        return static::where('name', $id)->first();
    }
}
