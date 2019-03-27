<!--
 * Created by PhpStorm.
 * User: ablin
 * Date: 2/28/19
 * Time: 11:22 PM
 */
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Matcha - Log in</title>
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
    header('Location: /Matcha/?e=log');
?>

<div class="container mt-5 small-page-wrapper">
    <div class="wrapper col-8 offset-2 p-2">
        <div class="container col-8 p-2 mt-3 mb-3">
            <form id="login" name="login" @submit.prevent="processForm" class="register-form col-10 offset-1 my-2 my-lg-0" method="post" action="login_user.php">
                <div class="form-group">
                    <label for="username" class="lab">Username</label>
                    <input type="text"
                           name="username"
                           placeholder="ablin42"
                           id="username"
                           class="form-control"
                           maxlength="30"
                           v-model="username"
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
                           v-model="password"
                           required>
                </div>
                <div class="form-group">
                    <button type="submit" name="submit_login" class="btn btn-outline-warning btn-sign-in">Log in</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-12 p-3 mt-5">
        <h5>No account yet? Create one <a href="/Matcha/">here</a></h5>
    </div>
</div>

<?php require_once("includes/footer.php");?>
<script src="vuejs/login.js"></script>
<script src="js/ajaxify.js"></script>
<script src="js/alert.js"></script>
</body>
</html>