<!--
 * Created by PhpStorm.
 * User: ablin
 * Date: 2/21/19
 * Time: 10:18 PM
 * -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Matcha</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style/bootstrap.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
</head>

<body>
<?php
require_once("includes/header.php");
?>

<div class="container mt-5 small-page-wrapper">
    <div class="wrapper col-8 offset-2 p-2">
        <h1>create an account</h1>
        <h5>a confirmation e-mail will be sent to you</h5>
        <div class="container col-8 p-2 mt-3 mb-3">
            <form id="register" name="register" @submit.prevent="processForm" class="register-form col-10 offset-1 my-2 my-lg-0" method="post" action="register_user.php">
                <div class="form-group">
                    <label for="username" class="lab">Username</label>
                    <input type="text"
                           name="username"
                           placeholder="ablin42"
                           id="username"
                           class="form-control"
                           maxlength="30"
                           v-model="username"
                           :style="{ borderColor: borderColor.username }"
                           @blur="validateUsername"
                           required>
                    <span v-if="errors.username">Username must contain between 4 and 30 characters</span>
                </div>
                <div class="form-group">
                    <label for="email" class="lab">E-mail</label>
                    <input type="email"
                           name="email"
                           placeholder="ablin42@byom.de"
                           id="email" class="form-control"
                           maxlength="255"
                           v-model="email"
                           :style="{ borderColor: borderColor.email }"
                           @blur="validateEmail"
                           required>
                    <span v-if="errors.email">E-mail has to be valid</span>
                </div>
                <div class="form-group">
                    <label for="password" class="lab">Password</label>
                    <input type="password"
                           name="password"
                           placeholder="********"
                           id="password"
                           class="form-control"
                           maxlength="30"
                           v-model="password"
                           :style="{ borderColor: borderColor.password }"
                           @blur="validatePassword"
                           required>
                    <span v-if="errors.password">Password must contain between 8 and 30 characters and has to be atleast alphanumeric</span>
                </div>
                <div class="form-group">
                    <label for="password2" class="lab">Confirm your password</label>
                    <input type="password"
                           name="password2"
                           placeholder="********"
                           id="password2"
                           class="form-control"
                           maxlength="30"
                           v-model="password2"
                           :style="{ borderColor: borderColor.password2 }"
                           @blur="validatePassword2"
                           required>
                    <span v-if="errors.password2">Password has to be the same as the one you just entered</span>
                </div>
                <div class="form-group">
                    <button type="submit" name="submit_register" class="btn btn-outline-warning btn-sign-in">Sign up</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-12 p-3 mt-5">
        <h5>Already have an account? You can log in at the top right corner of the page!</h5>
        <h6>Else you can go back to the main page <a href="/Camagru/">here</a></h6>
    </div>
</div>

<?php require_once("includes/footer.php");?>
<script src="registerForm.js"></script>
<script src="js/ajaxify.js"></script>
<script src="js/alert.js"></script>
</body>
</html>