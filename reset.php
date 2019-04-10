<!-- /**
 * Created by PhpStorm.
 * User: ablin
 * Date: 3/19/19
 * Time: 7:45 PM
 */-->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Matcha - New password</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style/bootstrap.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
<?php
require_once("includes/header.php");
if (isset($_SESSION['logged']) && $_SESSION['logged'] === 1)
    header('Location: /Matcha/Account?e=logg');
if (!isset($_GET['id']) && !isset($_GET['token']))
    header('Location: /Matcha?e=reset');
?>
<div class="container mt-5 small-page-wrapper">
    <div class="wrapper col-8 offset-2 p-2">
        <h1>reset your password</h1>
        <h5>you will need to log in after changing your password</h5>
        <div class="container col-8 p-3 mt-3 mb-3">
            <form id="resetpwd" name="resetpwd" @submit.prevent="processForm" class="register-form col-10 offset-1 my-2 my-lg-0" method="post">
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
                <?php echo $form->hidden("id", $_GET['id'], "id_user");
                      echo $form->hidden("token", $_GET['token'], "token");?>
                <div class="form-group">
                    <button type="submit" name="submit_register" class="btn btn-outline-warning btn-sign-in">Set New Password</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-12 p-3 mt-5">
        <h5>Make sure to remember your password this time!</h5>
    </div>
</div>
<?php require_once("includes/footer.php");?>
<script src="js/online.js"></script>
<script src="vuejs/resetPwd.js"></script>
<script src="js/alert.js"></script>
<script src="js/ajaxify.js"></script>
</body>
</html>