<?php

namespace App\Console;

use App\Sensor;
use App\Room;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function() {
			$portCOM0 = "/dev/ttyACM0";
			$portCOM1 = "/dev/ttyACM1";
			$patternsensors = "/sensorsbegin (.*?)sensorsend/";
			$fp = fopen($portCOM0, "r");
			sleep(1);
			$data = file_get_contents($portCOM0);
			if (preg_match($patternsensors, $data, $matches1))
			{
				$text1 = (string)$matches1[1];
				$text1 = str_replace(array("sensorsbegin /","sensorsend"), "", $text1);
				$text1 = preg_split("/[\s]+/", $text1);
							
				for ($i = 2; $i < count($text1); $i=$i+3)
				{
                    $room = Room::where('name', $text1[$i-2])->first();
                    $sensor = $room->sensor()->create([
                        'name' => $text1[$i-1],
                        'result' => (float) $text1[$i],
                    ]);

					// $sensor = new Sensor;
					// $sensor->room_id = Room::where("name", $text1[$i-2])->first()->id;
					// $sensor->name = $text1[$i-1];
					// $sensor->result = (float) $text1[$i];
					// $sensor->save();
				}
			}		
		})->everyFiveMinutes();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
