var imported = document.createElement('script');
imported.src = 'js/functions.js';
document.head.appendChild(imported);

let report = new Vue({
    el: '#report-btn',
    data: {reported: false},
    methods: {
        reportUser: function (id) {
            this.reported = true;
            fetch('handlers/report_user.php', {
                method: 'post',
                mode: 'same-origin',
                headers: {'Content-Type': 'application/json'}, //sent
                body: JSON.stringify({
                    user_id: id
                })
            })
                .then((res) => res.text())
                .then((data) => addAlert(data, document.getElementById("header")))
                .catch((error) => console.log(error))
        }
    }
});

let block = new Vue({
    el: '#block-btn',
    methods: {
        blockUser: function (id) {
            let block = document.getElementById('block');
            if (block.innerHTML.indexOf("Unblock") !== -1)
                block.innerHTML = "<i class=\"fas fa-ban\"></i> Block user";
            else
                block.innerHTML = "<i class=\"fas fa-ban\"></i> Unblock user";
            fetch('handlers/block_user.php', {
                method: 'post',
                mode: 'same-origin',
                headers: {'Content-Type': 'application/json'}, //sent
                body: JSON.stringify({
                    user_id: id
                })
            })
                .then((res) => res.text())
                .then((data) => addAlert(data, document.getElementById("header")))
                .catch((error) => console.log(error))
        }
    }
});

let vote = new Vue({
    el: '#vote',
    data: {},
    methods: {
        vote: function (id, vote){
            let likebtn = document.querySelector('.like'),
                liked = document.querySelector('.liked'),
                dislikebtn = document.querySelector('.dislike'),
                disliked = document.querySelector('.disliked');
            if (vote === 1)
            {
                if (likebtn && !liked) {
                    likebtn.classList.add('liked');
                    if (disliked)
                        disliked.classList.remove('disliked');
                }
                else if (liked)
                    likebtn.classList.remove('liked');
            }
            else if (vote === -1){
                if (dislikebtn && !disliked){
                    dislikebtn.classList.add('disliked');
                    if (liked)
                        liked.classList.remove('liked');
                }
                else if (disliked)
                    dislikebtn.classList.remove('disliked');
            }

            fetch('handlers/like_user.php', {
                method: 'post',
                mode: 'same-origin',
                headers: {'Content-Type': 'application/json'}, //sent
                body: JSON.stringify({
                    user_id: id, vote: vote
                })
            })
                .then((res) => res.text())
                .then((data) => addAlert(data, document.getElementById("header")))
                .catch((error) => console.log(error))
        }
    }
});