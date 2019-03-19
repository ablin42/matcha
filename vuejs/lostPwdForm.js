let lostpw = new Vue({
    el: '#lostpw',
    data: {
        email: '',
        borderColor: {
            email: ''
        },
        errors: {
            email: false,
        }
    },
    methods: {
        processForm: function () {
            if (this.errors.email === true) {
                addAlert('<div id="alert" class="alert alert-warning" style="text-align: center;" role="alert"><b>Error:</b> Please fill in the field properly.\n' +
                    '            <button type="button" class="close" onclick="dismissAlert(this)" data-dismiss="alert" aria-label="Close">\n' +
                    '                <span aria-hidden="true">×</span>\n' +
                    '            </button>\n' +
                    '            </div>', document.getElementById("header"))
            }
            else {
                fetch('handlers/reset_pwd.php', {
                    method: 'post',
                    mode: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json' //sent
                    },
                    body: JSON.stringify({
                        email: this.email
                    })
                })
                    .then((res) => res.text())
                    .then((data) => addAlert(data, document.getElementById("header")))
                    .catch((error) => console.log(error))
            }
        },
        validateEmail: function () {
            const isValid = isValidEmail(this.email);
            if (isValid)
                this.borderColor.email = "#56c93f";
            else
                this.borderColor.email = "#FF0000";
            this.errors.email = !isValid;
        }
    }
});

function isValidEmail(email) {
    if (email.length !== 0 && (email.length < 3 || email.length > 255) ||
        !(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email)))
        return false;
    return true;
}
