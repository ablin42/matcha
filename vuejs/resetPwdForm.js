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
            if (this.errors.password === true || this.errors.password === true || id == null || token == null) {
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
                    .then((data) => addAlert(data, document.getElementById("header")))
                    .catch((error) => console.log(error))
            }
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

function isValidPassword(password) {
    if (password.length > 30 || !/^(((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(.{8,})/.test(password))
        return false;
    return true;
}
