function validate() {
    var username = document.getElementById("username"),
        email = document.getElementById("email"),
        password = document.getElementById("password"),
        password2 = document.getElementById("password2");


    if (username) {
        if (username.value.length !== 0 && (username.value.length < 4 || username.value.length > 30)) {
            document.getElementById("i_username").style.display = "inline-block";
            username.classList.add("invalid");
        }
        else if (username.value.length >= 4 || username.value.length <= 30) {
            document.getElementById("i_username").style.display = "none";
            username.classList.remove("invalid");
            username.classList.add("valid");
        }
        else {
            document.getElementById("i_username").style.display = "none";
            username.classList.remove("invalid");
            username.classList.remove("valid");
        }
    }

    if (email) {
        if (email.value.length !== 0 && (email.value.length < 3 || email.value.length > 255)){
            document.getElementById("i_email").style.display = "inline-block";
            email.classList.add("invalid");
        }
        else if (email.value.length !== 0) {
            if (/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email.value))
            {
                document.getElementById("i_email").style.display = "none";
                email.classList.remove("invalid");
                email.classList.add("valid");
            }
        }
        else {
            document.getElementById("i_email").style.display = "none";
            email.classList.remove("invalid");
            email.classList.remove("valid");
        }
    }

    if (password) {
        if (password.value.length > 0 && (password.value.length > 30 || !/^(((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(.{8,})/.test(password.value))) {
            document.getElementById("i_password").style.display = "inline-block";
            password.classList.add("invalid");
        }
        else if (password.value.length !== 0) {
            document.getElementById("i_password").style.display = "none";
            password.classList.remove("invalid");
            password.classList.add("valid");
        }
        else {
            document.getElementById("i_password").style.display = "none";
            password.classList.remove("invalid");
            password.classList.remove("valid");
        }
    }

    if (password2) {
        if (password2.value.length !== 0 && (password.value !== password2.value)) {
            document.getElementById("i_password2").style.display = "inline-block";
            password2.classList.add("invalid");
        }
        else if (password2.value.length !== 0) {
            document.getElementById("i_password2").style.display = "none";
            password2.classList.remove("invalid");
            password2.classList.add("valid");
        }
        else {
            document.getElementById("i_password2").style.display = "none";
            password2.classList.remove("invalid");
            password2.classList.remove("valid");
        }
    }

}