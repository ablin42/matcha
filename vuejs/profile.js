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
            if (vote === 1)
            {
                let btn = document.querySelector('.like'),
                    liked = document.querySelector('.liked');
                if (btn && !liked)
                    btn.classList.add('liked');
                else if (liked)
                    btn.classList.remove('liked');
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