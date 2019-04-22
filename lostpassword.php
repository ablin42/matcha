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
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
<?php
require_once("includes/header.php");
if (isset($_SESSION['logged']) && $_SESSION['logged'] === 1)
    header('Location: /Matcha/Account?e=logg');
?>
<div class="container mt-5 small-page-wrapper">
    <div class="col-lg-8 mx-auto p-2">
        <h1 class="banner">enter your e-mail</h1>
        <h3>we will send you a mail to reset your password</h3>
        <div class=" container col-8 p-3 mt-3 mb-3">
            <form id="lostpw" name="lostpw" @submit.prevent="processForm" class="register-form col-10 offset-1 my-2 my-lg-0" method="post">
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
                    <button type="submit" name="submit_register" class="btn btn-outline-warning btn-sign-in"><span>Reset my password</span></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once("includes/footer.php");?>
<script src="js/online.js"></script>
<script src="vuejs/lostPwd.js"></script>
<script src="js/alert.js"></script>

</body>
</html>