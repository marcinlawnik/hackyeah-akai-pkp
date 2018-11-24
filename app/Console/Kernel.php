<?php

namespace App\Console;

use App\Picture;
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
        $schedule->call(function(){
            $image = Picture::inRandomOrder()->first();
            \Ratchet\Client\connect('ws://hatechat.akai.org.pl/websocket/')->then(function($conn) {
                $conn->send(json_encode(['type' => 'image', 'msg' => $image->url]));
            }, function ($e) {
                echo "Could not connect: {$e->getMessage()}\n";
            });
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
