@extends('app')

@section('content')
    <script type="text/javascript">
        var conn = new WebSocket('ws://hatechat.akai.org.pl/websocket/');
        conn.onopen = function(e) {
            console.log("Connection established!");
        };
        window.onload = function () {
            var chatDiv = document.getElementById('chat');
            var sendButton = document.getElementById('send');
            var chatInput = document.getElementById('chatInput');
            //Listenery
            conn.onmessage = function(e) {
                const parsed = JSON.parse(e.data);
                console.log(parsed);
                chatDiv.innerHTML += '<p>' + parsed.msg + '</p><br>';
            };



        }
    </script>
    <div class="container" id="chat">

    </div>
    <input type="text" id="chatInput">
    <button id="send">
        Send
    </button>

    <p>
        <a href="/train_list">lista pociągów</a>
    </p>
@endsection