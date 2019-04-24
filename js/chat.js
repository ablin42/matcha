var chat = new Vue({
    el: '#chat',
    data: {
        message: '',
        roomid: ''
    },
    methods: {
        sendChat: function (id, roomid) {
            this.roomid = roomid;
            this.updateChat(roomid);
            document.getElementById("message").value = "";
            fetch('utils/process_chat.php', {
                method: 'post',
                mode: 'same-origin',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    'function': 'send','message': this.message, 'roomid': roomid
                })
            })
                .then((res) => res.text())
                .then(function(data){
                    chat.updateChat();
                })
                .catch((error) => console.log(error))
        },
        updateChat: function () {
            fetch('utils/process_chat.php', {
                method: 'post',
                mode: 'same-origin',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    'function': 'update', 'roomid': this.roomid
                })
            })
                .then((res) => res.text())
                .then(function(data){
                    document.getElementById('chat-area').innerHTML = data;
                })
                .catch((error) => console.log(error))
        }
    }
});

//Updates the chat
$(document).ready(function() {
    fetch('utils/process_chat.php', {
        method: 'post',
        mode: 'same-origin',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            'function': 'update', 'roomid': roomid
        })
    })
        .then((res) => res.text())
        .then(function(data){
            document.getElementById('chat-area').innerHTML = data;
        })
        .catch((error) => console.log(error))
});

var updateChat = setInterval(function () {
    fetch('utils/process_chat.php', {
        method: 'post',
        mode: 'same-origin',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            'function': 'update', 'roomid': roomid
        })
    })
        .then((res) => res.text())
        .then(function(data){
            document.getElementById('chat-area').innerHTML = data;
        })
        //.catch((error) => console.log(error))
}, 5000);////////////*/