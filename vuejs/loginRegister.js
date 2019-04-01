var imported = document.createElement('script');
imported.src = 'js/functions.js';
document.head.appendChild(imported);

Vue.component('login-signup-tab', {
    template: `
        <div>
            <div class="text-center">
                <h4
                    class="d-inline-block m-2"
                    :class="{ activeTab: selectedTab === tab} "
                    v-for="(tab, index) in tabs" 
                    :key="index"
                    @click="selectedTab = tab">
                    {{ tab }}
                </h4>
            </div>
            
             <form v-if="selectedTab === 'Log in'" name="login" @submit.prevent="processLogin" class="register-form col-10 offset-1 my-2 my-lg-0" method="post">
                <div class="form-group">
                    <label for="username" class="lab">Username</label>
                    <input type="text"
                           name="username"
                           placeholder="ablin42"
                           id="username"
                           class="form-control"
                           maxlength="30"
                           v-model="login.username"
                           required>
                </div>
                <div class="form-group">
                    <label for="password" class="lab">Password</label>
                    <input type="password"
                           name="password"
                           placeholder="********"
                           id="password"
                           class="form-control"
                           maxlength="30"
                           v-model="login.password"
                           required>
                </div>
                <div class="form-group">
                    <button type="submit" name="submit_login" class="btn btn-outline-warning btn-sign-in">Log in</button>
                </div>
            </form>
            
            <div id="register-wrapper" v-if="selectedTab === 'Register'">
                <h1>create an account</h1>
                <h5 >a confirmation e-mail will be sent to you</h5>
            <form id="register" name="register" @submit.prevent="processRegister" class="register-form col-10 offset-1 my-2 my-lg-0" method="post">
                <div class="form-group">
                    <label for="firstname" class="lab">First Name</label>
                    <input type="text"
                           name="firstname"
                           placeholder="John"
                           id="firstname"
                           class="form-control"
                           maxlength="16"
                           v-model="register.firstname"
                           :style="{ borderColor: register.borderColor.firstname }"
                           @blur="validateFirstname"
                           required>
                    <span v-if="register.errors.firstname">First name must contain between 2 and 16 characters</span>
                </div>
                <div class="form-group">
                    <label for="lastname" class="lab">Last Name</label>
                    <input type="text"
                           name="lastname"
                           placeholder="Doe"
                           id="lastname"
                           class="form-control"
                           maxlength="16"
                           v-model="register.lastname"
                           :style="{ borderColor: register.borderColor.lastname }"
                           @blur="validateLastname"
                           required>
                    <span v-if="register.errors.lastname">Last name must contain between 2 and 16 characters</span>
                </div>
                <div class="form-group">
                    <label for="birthyear" class="lab">Birth year</label>
                    <input type="number"
                           name="birthyear"
                           placeholder="1984"
                           id="birthyear"
                           class="form-control"
                           min="1940"
                           max="2001"
                           v-model.number="register.birthYear"
                           :style="{ borderColor: register.borderColor.birthYear }"
                           @blur="validateBirthYear"
                           required>
                    <span v-if="register.errors.birthYear">Your birth year must be in the range 1940-2001</span>
                </div>
                <div class="form-group">
                    <label for="username" class="lab">Username</label>
                    <input type="text"
                           name="username"
                           placeholder="ablin42"
                           id="r_username"
                           class="form-control"
                           maxlength="30"
                           v-model="register.username"
                           :style="{ borderColor: register.borderColor.username }"
                           @blur="validateUsername"
                           required>
                    <span v-if="register.errors.username">Username must contain between 4 and 30 characters</span>
                </div>
                <div class="form-group">
                    <label for="email" class="lab">E-mail</label>
                    <input type="email"
                           name="email"
                           placeholder="ablin42@byom.de"
                           id="email" class="form-control"
                           maxlength="255"
                           v-model="register.email"
                           :style="{ borderColor: register.borderColor.email }"
                           @blur="validateEmail"
                           required>
                    <span v-if="register.errors.email">E-mail has to be valid</span>
                </div>
                <div class="form-group">
                    <label for="password" class="lab">Password</label>
                    <input type="password"
                           name="password"
                           placeholder="********"
                           id="r_password"
                           class="form-control"
                           maxlength="30"
                           v-model="register.password"
                           :style="{ borderColor: register.borderColor.password }"
                           @blur="validatePassword"
                           required>
                    <span v-if="register.errors.password">Password must contain between 8 and 30 characters and has to be atleast alphanumeric</span>
                </div>
                <div class="form-group">
                    <label for="password2" class="lab">Confirm your password</label>
                    <input type="password"
                           name="password2"
                           placeholder="********"
                           id="password2"
                           class="form-control"
                           maxlength="30"
                           v-model="register.password2"
                           :style="{ borderColor: register.borderColor.password2 }"
                           @blur="validatePassword2"
                           required>
                    <span v-if="register.errors.password2">Password has to be the same as the one you just entered</span>
                </div>
                <div class="form-group">
                    <button type="submit" name="submit_register" class="btn btn-outline-warning btn-sign-in">Sign up</button>
                </div>
            </form>
            </div>
        </div>
   `,
    data: function(){
        return {
            tabs: ['Log in', 'Register'],
            selectedTab: "Log in",
            login: {
                username: "",
                password: ""
            },
            register: {
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
            }
        }
    },
    methods: {
        processLogin: function(){
            this.$parent.processLogin(this.login.username, this.login.password);
        },
        processRegister: function(){
            this.$parent.processRegister(this.register.errors, this.register.firstname, this.register.lastname, this.register.birthYear,
                                        this.register.username, this.register.email, this.register.password, this.register.password2, );
        },
        validateFirstname: function () {
            const isValid = isValidLength(this.register.firstname, 2, 16);
            if (isValid)
                this.register.borderColor.firstname = "#56c93f";
            else
                this.register.borderColor.firstname = "#FF0000";

            this.register.errors.firstname = !isValid;
        },
        validateLastname: function () {
            const isValid = isValidLength(this.register.lastname, 2, 16);
            if (isValid)
                this.register.borderColor.lastname = "#56c93f";
            else
                this.register.borderColor.lastname = "#FF0000";

            this.register.errors.lastname = !isValid;
        },
        validateBirthYear: function () {
            const isValid = isValidLength(this.register.birthYear.toString(), 4, 4);
            if (isValid && this.register.birthYear >= 1940 && this.register.birthYear <= 2001)
                this.register.borderColor.birthYear = "#56c93f";
            else
                this.register.borderColor.birthYear = "#FF0000";

            if (this.register.birthYear < 1940 || this.register.birthYear > 2001)
                this.register.errors.birthYear = true;
            else
                this.register.errors.birthYear = false;
        },
        validateUsername: function () {
            const isValid = isValidLength(this.register.username, 4, 30);
            if (isValid)
                this.register.borderColor.username = "#56c93f";
            else
                this.register.borderColor.username = "#FF0000";

            this.register.errors.username = !isValid;
        },
        validateEmail: function () {
            const isValid = isValidEmail(this.register.email);
            if (isValid)
                this.register.borderColor.email = "#56c93f";
            else
                this.register.borderColor.email = "#FF0000";
            this.register.errors.email = !isValid;
        },
        validatePassword: function () {
            const isValid = isValidPassword(this.register.password);
            if (isValid)
                this.register.borderColor.password = "#56c93f";
            else
                this.register.borderColor.password = "#FF0000";
            this.register.errors.password = !isValid;
        },
        validatePassword2: function () {
            if (this.register.password2 !== this.register.password) {
                this.register.errors.password2 = true;
                this.register.borderColor.password2 = "#FF0000";
            }
            else {
                this.register.errors.password2 = false;
                this.register.borderColor.password2 = "#56c93f";
            }
        }
    }
});

let login = new Vue({
    el: '#login-register',
    methods: {
        processLogin: function (user, pwd) {
            fetch('handlers/login_user.php', {
                method: 'post',
                mode: 'same-origin',
                headers: {'Content-Type': 'application/json'}, //sent
                body: JSON.stringify({
                    username: user, password: pwd
                }),
            })
                .then((res) => res.text())
                .then(function(data){
                    addAlert(data, document.getElementById("header"));
                    if (data.indexOf("logged in!") !== -1)
                        setTimeout(function () {
                            window.location.href = "/Matcha/Activity";
                        }, 1000);
                })
                .catch((error) => console.log(error));
        },
        processRegister: function (errors, firstname, lastname, birthYear, username, email, password, password2) {
            if (errors.username === true || errors.email === true ||
                errors.password === true || errors.password2 === true ||
                errors.firstname === true || errors.lastname === true || errors.birth_year === true) {
                addAlert('<div id="alert" class="alert alert-warning" style="text-align: center;" role="alert"><b>Error:</b> Please fill in the fields properly.\n' +
                    '            <button type="button" class="close" onclick="dismissAlert(this)" data-dismiss="alert" aria-label="Close">\n' +
                    '                <span aria-hidden="true">×</span>\n' +
                    '            </button>\n' +
                    '            </div>', document.getElementById("header"))
            } else {
                fetch('handlers/register_user.php', {
                    method: 'post',
                    mode: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json' //sent
                    },
                    body: JSON.stringify({
                        firstname: firstname, lastname: lastname, birth_year: birthYear,
                        username: username, email: email,
                        password: password, password2: password2
                    })
                })
                    .then((res) => res.text())
                    .then(function(data){
                        addAlert(data, document.getElementById("header"));
                        if (data.indexOf("successfully") !== -1)
                            setTimeout(function () {
                                window.location.href = "/Matcha/Login";
                            }, 1000);
                    })
                    .catch((error) => console.log(error))
            }
        }
    }
});