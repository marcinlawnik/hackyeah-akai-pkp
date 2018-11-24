@extends('app')

@section('content')
    <script type="text/javascript">
        var conn = new WebSocket('ws://hatechat.akai.org.pl/websocket/');
        conn.onopen = function(e) {
            console.log("Connection established!");
        };
        window.onload = function () {
            var chatDiv = document.getElementById('chat');
            const imageDiv = document.getElementById('image');
            var chatForm = document.getElementById('chatForm');
            var chatInput = document.getElementById('chatInput');
            const imageButton = document.getElementById('imageButton');
            //Listenery
            const sendMessage = function (e) {
                e.preventDefault();
                conn.send(JSON.stringify({type:"chat", chat_msg: chatInput.value}));
                this.reset();
            }
            chatForm.addEventListener("submit", sendMessage);
            // const sendImage = function () {
            //     conn.send(JSON.stringify({type:"image", chat_msg: chatInput.value}));
            // }
            // imageButton.addEventListener("click", sendImage);
            conn.onmessage = function(e) {
                const parsed = JSON.parse(e.data);
                console.log(parsed);
                if(parsed.type == 'image'){
                    imageDiv.innerHTML = '<img src="' + parsed.msg + '">';
                } else {
                    chatDiv.innerHTML += '<p>' + parsed.msg + '</p><br>';
                }
            };



        }
    </script>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <img src="/svg/logo_devil.svg" width="200px" height="200px">
            </div>
        </div>
        <div class="row" style="display: flex;">
            <div class="col-sm-6"  style="flex:1;">
                <div id="image"></div>
            </div>
            <div class="col-sm-6" style="flex:1;">
                <div id="chat"></div>
                <input type="text" id="chatInput">
                <form id="chatForm">
                    <input type="submit" value="SEND" id="send">
                </form>

                {{--<button id="imageButton">--}}
                    {{--OBRAZEK--}}
                {{--</button>--}}
            </div>
        </div>
    </div>



@endsection