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

let vote = new Vue({
    el: '#vote',
    data: {},
    methods: {
        vote: function (id, vote){
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