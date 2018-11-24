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
            const imageButton = document.getElementById('imageButton');
            //Listenery
            const sendMessage = function () {
                // console.log(chatInput.value);
                conn.send(JSON.stringify({type:"chat", chat_msg: chatInput.value}));
            }
            sendButton.addEventListener("click", sendMessage);
            const sendImage = function () {
                conn.send(JSON.stringify({type:"image", chat_msg: chatInput.value}));
            }
            imageButton.addEventListener("click", sendImage);
            conn.onmessage = function(e) {
                const parsed = JSON.parse(e.data);
                console.log(parsed);
                if(parsed.type == 'image'){
                    chatDiv.innerHTML = '<img src="' + parsed.msg + '">';
                } else {
                    chatDiv.innerHTML += '<p>' + parsed.msg + '</p><br>';
                }
            };



        }
    </script>
    <div class="container" id="chat">

    </div>
    <input type="text" id="chatInput">
    <button id="send">
        Send
    </button>
    <button id="imageButton">
        OBRAZEK
    </button>

@endsection