<!--/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 3/19/19
 * Time: 7:15 PM
 */-->

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Matcha - Reset your password</title>
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
if (isset($_SESSION['logged']) && $_SESSION['logged'] === 1)
    header('Location: /Matcha/?e=pw');
?>
<div class="container mt-5 small-page-wrapper">
    <div class="wrapper col-8 offset-2 p-2">
        <h1>enter your e-mail</h1>
        <h5>we will send you a mail to reset your password</h5>
        <div class="register-form-wrapper container col-8 p-3 mt-3 mb-3">
            <form id="lostpw" name="lostpw" @submit.prevent="processForm" class="col-10 offset-1 my-2 my-lg-0" method="post">
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
                    <button type="submit" name="submit_register" class="btn btn-outline-warning btn-sign-in">Reset my password</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-12 p-3 mt-5">
        <h5>If you're logged and simply wish to change your password, click <a href="/Matcha/account">here</a></h5>
    </div>
</div>

<?php require_once("includes/footer.php");?>
<script src="vuejs/lostPwd.js"></script>
<script src="js/alert.js"></script>
<script src="js/ajaxify.js"></script>
</body>
</html>