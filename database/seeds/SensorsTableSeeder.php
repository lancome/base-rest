<?php

use Illuminate\Database\Seeder;
use App\Room;
use App\User;
use App\Sensor;

class SensorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = new User;
        $user->name = 'Jegor';
        $user->email = 'admin@gmail.com';
        $user->password = bcrypt('123123');
        $user->save();

        User::first()->rooms()->create([
            'name' => 'Bedroom',
        ]);
        User::first()->rooms()->create([
            'name' => 'Kitchen',
        ]);
        User::first()->rooms()->create([
            'name' => 'WC',
        ]);
        Room::where('name','Bedroom')->first()->sensors()->create([
            'name' => 'Temperature',
            'result' => 22.0,
        ]);
        Room::where('name','Kitchen')->first()->sensors()->create([
            'name' => 'Temperature',
            'result' => 23.5,
        ]);
        Room::where('name','WC')->first()->sensors()->create([
            'name' => 'Temperature',
            'result' => 20.0,
        ]);

        Room::where('name','Bedroom')->first()->sensors()->create([
            'name' => 'PIR',
            'result' => 1,
        ]);
        Room::where('name','Kitchen')->first()->sensors()->create([
            'name' => 'PIR',
            'result' => 0,
        ]);
        Room::where('name','WC')->first()->sensors()->create([
            'name' => 'PIR',
            'result' => 0,
        ]);

        Room::where('name','Bedroom')->first()->sensors()->create([
            'name' => 'Pressure',
            'result' => 1020.0,
        ]);
        Room::where('name','Kitchen')->first()->sensors()->create([
            'name' => 'Pressure',
            'result' => 1021.0,
        ]);
        Room::where('name','WC')->first()->sensors()->create([
            'name' => 'Pressure',
            'result' => 1022.0,
        ]);
    }
}
