var imported = document.createElement('script');
imported.src = 'js/functions.js';
document.head.appendChild(imported);

let register = new Vue({
    el: '#register',
    data: {
        firstname: '',
        lastname: '',
        birthYear: '',
        username: '',
        email: '',
        password: '',
        password2: '',
        borderColor: {
            firstname: '',
            lastname: '',
            birthYear: '',
            username: '',
            email: '',
            password: '',
            password2: ''
        },
        errors: {
            firstname: false,
            lastname: false,
            birthYear: false,
            username: false,
            email: false,
            password: false,
            password2: false
        }
    },
    methods: {
        processForm: function () {
            if (this.errors.username === true || this.errors.email === true ||
                this.errors.password === true || this.errors.password2 === true ||
                this.errors.firstname === true || this.errors.lastname === true || this.errors.birth_year === true) {
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
                        firstname: this.firstname, lastname: this.lastname, birth_year: this.birthYear,
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
        validateBirthYear: function () {
            const isValid = isValidLength(this.birthYear.toString(), 4, 4);
            if (isValid && this.birthYear >= 1940 && this.birthYear <= 2001)
                this.borderColor.birthYear = "#56c93f";
            else
                this.borderColor.birth_year = "#FF0000";

            if (this.birth_year < 1940 || this.birthYear > 2001)
                this.errors.birthYear = true;
            else
                this.errors.birthYear = false;
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