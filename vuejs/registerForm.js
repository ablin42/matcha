let register = new Vue({
    el: '#register',
    data: {
        firstname: '',
        lastname: '',
        username: '',
        email: '',
        password: '',
        password2: '',
        borderColor: {
            username: '',
            email: '',
            password: '',
            password2: ''
        },
        errors: {
            firstname: false,
            lastname: false,
            username: false,
            email: false,
            password: false,
            password2: false
        }
    },
    methods: {
        processForm: function () {
            if (this.errors.username === true || this.errors.email === true ||
                this.errors.password === true || this.errors.password2 === true) {
                addAlert('<div id="alert" class="alert alert-warning" style="text-align: center;" role="alert"><b>Error:</b> Please fill in the fields properly.\n' +
                    '            <button type="button" class="close" onclick="dismissAlert(this)" data-dismiss="alert" aria-label="Close">\n' +
                    '                <span aria-hidden="true">×</span>\n' +
                    '            </button>\n' +
                    '            </div>', document.getElementById("header"))
            }
            else {
                fetch('handlers/register_user.php', {
                    method: 'post',
                    mode: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json' //sent
                    },
                    body: JSON.stringify({
                        firstname: this.firstname, lastname: this.lastname,
                        username: this.username, email: this.email,
                        password: this.password, password2: this.password2
                    })
                })
                    .then((res) => res.text())
                    .then((data) => addAlert(data, document.getElementById("header")))
                    .catch((error) => console.log(error))
            }
        },
        validateFirstname: function () {
            const isValid = isValidLength(this.firstname, 2, 16);
            if (isValid)
                this.borderColor.firstname = "#56c93f";
            else
                this.borderColor.firstname = "#FF0000";

            this.errors.firstname = !isValid;
        },
        validateLastname: function () {
            const isValid = isValidLength(this.lastname, 2, 16);
            if (isValid)
                this.borderColor.lastname = "#56c93f";
            else
                this.borderColor.lastname = "#FF0000";

            this.errors.lastname = !isValid;
        },
        validateUsername: function () {
            const isValid = isValidLength(this.username, 4, 30);
            if (isValid)
                this.borderColor.username = "#56c93f";
            else
                this.borderColor.username = "#FF0000";

            this.errors.username = !isValid;
        },
        validateEmail: function () {
            const isValid = isValidEmail(this.email);
            if (isValid)
                this.borderColor.email = "#56c93f";
            else
                this.borderColor.email = "#FF0000";
            this.errors.email = !isValid;
        },
        validatePassword: function () {
            const isValid = isValidPassword(this.password);
            if (isValid)
                this.borderColor.password = "#56c93f";
            else
                this.borderColor.password = "#FF0000";
            this.errors.password = !isValid;
        },
        validatePassword2: function () {
            if (this.password2 !== this.password) {
                this.errors.password2 = true;
                this.borderColor.password2 = "#FF0000";
            }
            else {
                this.errors.password2 = false;
                this.borderColor.password2 = "#56c93f";
            }
        }
    }
});


function isValidLength(string, min, max) {
    if (string.length < min || string.length > max)
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