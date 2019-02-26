//fetch function for php get
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
                console.log("error");
                //display notification
            }
            else {
                fetch('register_user.php', {
                    method: 'post',
                    mode: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',  // sent request
                        'Accept': 'application/json'   // expected data sent back
                    },
                    body: JSON.stringify({
                        username: this.username, email: this.email,
                        password: this.password, password2: this.password2
                    })
                })
                    .then((res) => res.json())
                    .then((data) => console.log(data))
                    .catch((error) => console.log(error))
            }
                /*fetch('register_user.php', {
                    method : 'post',
                    mode:    'same-origin',
                    headers: {
                        'Content-Type': 'application/json',  // sent request
                        'Accept':       'application/json'   // expected data sent back
                    },
                    body: JSON.stringify({min: 1, max: 100})
                })
                    .then((res) => res.json())
                    .then((data) => console.log(data))
                    .catch((error) => console.log(error))
            }*/
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
