let register = new Vue({
    el: '#register',
    data: {
        username: '',
        email: '',
        password: '',
        password2: '',
        errors: {
            username: false,
            email: false,
            password: false,
            password2: false
        }
    },
    methods: {
        processForm: function () {
            if (this.errors.username === true || this.errors.email === true ||
                this.errors.password === true || this.errors.password === true) {
                addAlert('<div id="alert" class="alert alert-warning" style="text-align: center;" role="alert"><b>Error:</b> Please fill in the fields properly.\n' +
                    '            <button type="button" class="close" onclick="dismissAlert(this)" data-dismiss="alert" aria-label="Close">\n' +
                    '                <span aria-hidden="true">×</span>\n' +
                    '            </button>\n' +
                    '            </div>', document.getElementById("header"))
            }
            else {
                fetch('register_user.php', {
                    method: 'post',
                    mode: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json' //sent
                    },
                    body: JSON.stringify({
                        username: this.username, email: this.email,
                        password: this.password, password2: this.password2
                    })
                })
                    .then((res) => res.text())
                    .then((data) => addAlert(data, document.getElementById("header")))
                    .catch((error) => console.log(error))
            }
        },
        validateUsername: function () {
            const isValid = isValidUsername(this.username);
            this.errors.username = !isValid;
        },
        validateEmail: function () {
            const isValid = isValidEmail(this.email);
            this.errors.email = !isValid;
        },
        validatePassword: function () {
            const isValid = isValidPassword(this.password);
            this.errors.password = !isValid;
        },
        validatePassword2: function () {
            if (this.password2 !== this.password)
                this.errors.password2 = true;
            else
                this.errors.password2 = false;
        }
    }
});

let login = new Vue({
    el: '#login',
    data: {
        username: '',
        password: '',
        errors: {
            username: false,
            password: false
        }
    },
    methods: {
        processForm: function () {
            if (this.errors.username === true || this.errors.email === true ||
                this.errors.password === true || this.errors.password === true) {
                addAlert('<div id="alert" class="alert alert-warning" style="text-align: center;" role="alert"><b>Error:</b> Please fill in the fields properly.\n' +
                    '            <button type="button" class="close" onclick="dismissAlert(this)" data-dismiss="alert" aria-label="Close">\n' +
                    '                <span aria-hidden="true">×</span>\n' +
                    '            </button>\n' +
                    '            </div>', document.getElementById("header"))
            }
            else {
                fetch('register_user.php', {
                    method: 'post',
                    mode: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        username: this.username, email: this.email,
                        password: this.password, password2: this.password2
                    })
                })
                    .then((res) => res.text())
                    .then((data) => addAlert(data, document.getElementById("header")))
                    .catch((error) => console.log(error))
            }
        },
        validateUsername: function () {
            const isValid = isValidUsername(this.username);
            this.errors.username = !isValid;
        },
        validatePassword: function () {
            const isValid = isValidPassword(this.password);
            this.errors.password = !isValid;
        }
    }
});


function isValidUsername(username) {
    if (username.length < 4 || username.length > 30)
        return false;
    return true;
}

function isValidEmail(email) {
    if (email.length !== 0 && (email.length < 3 || email.length > 255) ||
        !(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email)))
        return false;
    return true;
}

function isValidPassword(password) {
    if (password.length > 30 || !/^(((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(.{8,})/.test(password))
        return false;
    return true;
}