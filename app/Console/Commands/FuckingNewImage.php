<?php

namespace App\Console\Commands;

use App\Picture;
use Illuminate\Console\Command;

class FuckingNewImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fucking:image';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $image = Picture::inRandomOrder()->first();

        \Ratchet\Client\connect('ws://hatechat.akai.org.pl/websocket/')->then(function($conn) use ($image) {
            $conn->send(json_encode(['type' => 'image', 'chat_msg' => $image->url]));
            $conn->close();
        }, function ($e) {
            echo "Could not connect: {$e->getMessage()}\n";
        });
    }
}
