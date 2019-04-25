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
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <link rel="stylesheet" href="style/bootstrap.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
<?php
require_once("includes/header.php");
//if (isset($_SESSION['logged']) && $_SESSION['logged'] === 1)
  //  header('Location: /'.$pathurl.'/Account?e=logg');
if (isset($_GET['e']))
    redirection_handler($_GET['e']);
?>

<div class="container mt-5 small-page-wrapper">
    <h1 class="banner">Matcha <i class="far fa-heart"></i></h1>
        <div id="login-register" class="container col-lg-6 p-2 mt-3 mb-3">
            <login-signup-tab></login-signup-tab>
        </div>
</div>

<?php require_once("includes/footer.php");?>
<script src="js/online.js"></script>
<script src="vuejs/loginRegister.js"></script>
<script src="js/alert.js"></script>
<?php if ($_SESSION['logged'] === 1) echo '<script src="js/notif.js"></script>'; ?>
</body>
</html>
