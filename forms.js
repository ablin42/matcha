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
            console.log({name: this.username, email: this.email, pwd1: this.password, pwd2: this.password2})
        },
        validateUsername: function () {
            const isValid = isValidUsername(this.username);
            console.log(isValid);
            this.errors.username = !isValid;
        },
        validateEmail: function () {
            const isValid = isValidEmail(this.email);
            console.log(isValid);
            this.errors.email = !isValid;
        },
        validatePassword: function () {
            const isValid = isValidPassword(this.password);
            console.log(isValid);
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
