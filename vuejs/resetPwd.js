var imported = document.createElement('script');
imported.src = 'js/functions.js';
document.head.appendChild(imported);

let resetpwd = new Vue({
    el: '#resetpwd',
    data: {
        password: '',
        password2: '',
        borderColor: {
            password: '',
            password2: ''
        },
        errors: {
            password: false,
            password2: false
        }
    },
    methods: {
        processForm: function () {
            let id = document.getElementById("id_user").value,
                token = document.getElementById("token").value;
            if (this.errors.password === true || this.errors.password2 === true || id == null || token == null) {
                addAlert('<div id="alert" class="alert alert-warning" style="text-align: center;" role="alert"><b>Error:</b> Please fill in the field properly.\n' +
                    '            <button type="button" class="close" onclick="dismissAlert(this)" data-dismiss="alert" aria-label="Close">\n' +
                    '                <span aria-hidden="true">×</span>\n' +
                    '            </button>\n' +
                    '            </div>', document.getElementById("header"))
            }
            else {
                fetch('handlers/password_update.php', {
                    method: 'post',
                    mode: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json' //sent
                    },
                    body: JSON.stringify({
                        password: this.password, password2: this.password2, id_user: id, token: token
                    })
                })
                    .then((res) => res.text())
                    .then(function(data){
                        addAlert(data, document.getElementById("header"));
                        if (data.indexOf("Congratulations!") !== -1)
                            setTimeout(function () {
                                var getUrl = window.location,
                                    baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1],
                                    pathArray = window.location.pathname.split( '/' ),
                                    pathurl = "/" + pathArray[1] + "/";
                                window.location.href = pathurl;
                            }, 1000);
                    })
                    .catch((error) => console.log(error))
            }
        },
        validatePassword: function () {
            if (this.password.localeCompare('') !== 0) {
                const isValid = isValidPassword(this.password);
                if (isValid)
                    this.borderColor.password = "#56c93f";
                else
                    this.borderColor.password = "#FF0000";
                this.errors.password = !isValid;
            } else {
                this.borderColor.password = '';
                this.errors.password = false;
            }
        },
        validatePassword2: function () {
            if (this.password2.localeCompare('') !== 0) {
                if (this.password2 !== this.password) {
                    this.errors.password2 = true;
                    this.borderColor.password2 = "#FF0000";
                } else {
                    this.errors.password2 = false;
                    this.borderColor.password2 = "#56c93f";
                }
            } else {
                this.borderColor.password2 = '';
                this.errors.password2 = false;
            }
        }
    }
});
