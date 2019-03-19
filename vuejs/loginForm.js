let login = new Vue({
    el: '#login',
    data: {
        username: '',
        password: ''
    },
    methods: {
        processForm: function () {
            fetch('handlers/login_user.php', {
                method: 'post',
                mode: 'same-origin',
                headers: {'Content-Type': 'application/json'}, //sent
                body: JSON.stringify({
                    username: this.username, password: this.password
                })
            })
                .then((res) => res.text())
                .then((data) => addAlert(data, document.getElementById("header")))
                .catch((error) => console.log(error))
        }
    }
});