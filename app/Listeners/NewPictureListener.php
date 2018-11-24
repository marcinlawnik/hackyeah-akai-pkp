<?php

namespace App\Listeners;

use App\Events\NewPicture;

class SendShipmentNotification
{
/**
* Create the event listener.
*
* @return void
*/
public function __construct()
{
//
}

/**
* Handle the event.
*
* @param  \App\Events\NewPicture  $event
* @return void
*/
public function handle(NewPicture $event)
{
    \Ratchet\Client\connect('ws://echo.socketo.me:9000')->then(function($conn) {
        $conn->send(json_encode(['type' => 'image', 'msg' => $event]));
    }, function ($e) {
        echo "Could not connect: {$e->getMessage()}\n";
    });
}
}