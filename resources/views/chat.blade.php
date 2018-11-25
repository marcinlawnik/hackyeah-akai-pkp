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
            const fireVote = document.getElementById('fireVoteButton');
            const fireVoteCount = document.getElementById('fire_vote_count');
            //Listenery
            const sendMessage = function (e) {
                e.preventDefault();
                conn.send(JSON.stringify({type:"chat", chat_msg: chatInput.value}));
                document.getElementById('chatForm').reset();
            }
            chatForm.addEventListener("submit", sendMessage);
            const sendVote = function () {
                conn.send(JSON.stringify({type:"fire_vote", chat_msg: imageDiv.getElementsByTagName('img')[0].src}));
            }
            fireVote.addEventListener("click", sendVote);
            conn.onmessage = function(e) {
                const parsed = JSON.parse(e.data);
                console.log(parsed);
                switch (parsed.type) {
                    case 'image':
                        imageDiv.innerHTML = '<img src="' + parsed.msg + '">';
                        break;
                    case 'update_fire_vote_count':
                        fireVoteCount.innerText = parsed.msg;
                        break;
                    default:
                        chatDiv.innerHTML += '<p>' + parsed.msg + '</p><br>';
                        break;

                }
            };



        }
    </script>

    <div class="content container-fluid  h-100">
        <div class="row">
            <div class="navbar col-sm-12">
                <img src="/svg/logo_devil.svg" class="navbar-brand logo">
            </div>
        </div>
        <div class="row  h-100" style="display: flex;">
            <div class="col-sm-6  h-100"  style="flex:1;">
                <div id="image"></div>
            </div>
            <div class="col-sm-6" style="flex:1;">
                <div id="chat"></div>
                <div class="input container-fluid" style="display: flex; padding: 0;">
                    <textarea id="chatInput">
                    </textarea>

                    <form id="chatForm">

                        <div class="col-10" style="flex:1;">
                        <input type="submit" value="SEND" id="send">
                        </div>

                        <div class="col-2" style="flex:1;">
                        <p id="fire_vote_count"></p>
                        <button id="fireVoteButton">
                            <img src="/svg/fire.svg" width="50px" height="50px" style="display: inline;">
                        </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection