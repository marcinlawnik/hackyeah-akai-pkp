<?php
namespace App\Http\Controllers;
use App\Message;
use Exception;
use React\EventLoop\LoopInterface;
use React\EventLoop\TimerInterface;
use SplObjectStorage;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
/**
 * @author Rohit Dhiman | @aimflaiims
 */
class WebSocketController implements MessageComponentInterface
{
    private $loop;
    private $clients;
    public function __construct(LoopInterface $loop)
    {
        $this->loop = $loop;
        $this->clients = new SplObjectStorage;
    }
    /**
     * [onOpen description]
     * @method onOpen
     * @param  ConnectionInterface $conn [description]
     * @return [JSON]                    [description]
     * @example connection               var conn = new WebSocket('ws://localhost:8090');
     */
    public function onOpen(ConnectionInterface $conn)
    {
        echo "Client connected " . $conn->resourceId . " \n";
        $this->clients->attach($conn);
//        foreach ($this->clients as $client) {
//            $client->send(json_encode([
//                "type" => "socket",
//                "msg" => "Total Connected: " . count($this->clients)
//            ]));
//        }
    }
    /**
     * [onMessage description]
     * @method onMessage
     * @param  ConnectionInterface $conn [description]
     * @param  [JSON.stringify]              $msg  [description]
     * @return [JSON]                    [description]
     * @example message                  conn.send(JSON.stringify({command: "message", to: "1", from: "9", message: "it needs xss protection"}));
     * @example register                 conn.send(JSON.stringify({command: "register", userId: 9}));
     */
    public function onMessage(ConnectionInterface $from, $data)
    {
        $resource_id = $from->resourceId;
        $data = json_decode($data);
        $type = $data->type;
        switch ($type) {
            case 'chat':
                $chat_msg = $data->chat_msg;
                $response_to = "<span class='text-info'><b>" . $resource_id . "</b>: $chat_msg <span class='text-warning float-right'>" . date('Y-m-d h:i a') . "</span></span><br>";
                foreach ($this->clients as $client) {
                        $client->send(json_encode([
                            "type" => $type,
                            "msg" => $response_to
                        ]));
                }
                // Save to database
                echo "Resource id $resource_id sent $chat_msg \n";
                break;
            case 'image':
                foreach ($this->clients as $client) {
                    $client->send(json_encode([
                        "type" => 'image',
                        "msg" => $data->chat_msg
                    ]));
                }
                break;
            default:
                echo $data;
                break;
        }
    }
    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
    }
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

}