<!DOCTYPE html>
<html>
<head>
    <title>Socket.IO chat</title>
    <style>
        body { margin: 0; padding-bottom: 3rem; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; }

        #form { background: rgba(0, 0, 0, 0.15); padding: 0.25rem; position: fixed; bottom: 0; left: 0; right: 0; display: flex; height: 3rem; box-sizing: border-box; backdrop-filter: blur(10px); }
        #input { border: none; padding: 0 1rem; flex-grow: 1; border-radius: 2rem; margin: 0.25rem; }
        #input:focus { outline: none; }
        #form > button { background: #333; border: none; padding: 0 1rem; margin: 0.25rem; border-radius: 3px; outline: none; color: #fff; }

        #messages { list-style-type: none; margin: 0; padding: 0; }
        #messages > li { padding: 0.5rem 1rem; }
        #messages > li:nth-child(odd) { background: #efefef; }
    </style>
</head>
<body>
<ul id="messages"></ul>
<form id="form" action="">
    <input id="input" autocomplete="off" /><button>Send</button>
</form>
</body>
<script src="https://cdn.socket.io/4.5.4/socket.io.min.js" integrity="sha384-/KNQL8Nu5gCHLqwqfQjA689Hhoqgi2S84SNUxC3roTe4EhJ9AfLkp8QiQcU8AMzI" crossorigin="anonymous"></script><script>
    // the following forms are similar
    const socket = io("http://localhost:3000");

    var user_id =2;

    socket.on('connect', function() {
        socket.emit('user_connected', user_id);
    });
    socket.on('private-channel:App\\Events\\PrivateMessageEvent', function(msg) {
        console.log(msg)
        var item = document.createElement('li');
        item.textContent = msg.message;
        messages.appendChild(item);
        window.scrollTo(0, document.body.scrollHeight);
    });
</script>
</html>