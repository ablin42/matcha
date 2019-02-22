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
            <form onsubmit="return submitForm(this, 'register_user');" name="register" onkeyup="validate();" class="register-form col-10 offset-1 my-2 my-lg-0" action="register.php" method="post">
                <?php
                $form->setLabel('Username', 'lab');
                $form->setInfo('Username must contain between 4 and 30 characters', "i_username", "form-info", "y");
                echo $form->input('username', 'username', "form-control", "ablin42", 30);
                $form->setLabel('E-mail', 'lab');
                $form->setInfo('E-mail has to be valid', "i_email","form-info", "y");
                echo $form->email('email', 'email', "form-control", "ablin42@byom.de", 255);
                $form->setLabel('Password', 'lab');
                $form->setInfo('Password must contain between 8 and 30 characters and has to be atleast alphanumeric',"i_password", "form-info", "y");
                echo $form->password('password', 'password', "form-control", "********", 30);
                $form->setLabel('Confirm your password', 'lab');
                $form->setInfo('Password has to be the same as the one you just entered', "i_password2","form-info", "y");
                echo $form->password('password2', 'password2', "form-control", "********", 30);
                echo $form->submit('submit_register', 'submit_register', 'btn btn-outline-warning btn-sign-in', 'Sign up');
                ?>
            </form>
        </div>
    </div>
    <div class="col-12 p-3 mt-5">
        <h5>Already have an account? You can log in at the top right corner of the page!</h5>
        <h6>Else you can go back to the main page <a href="/Camagru/">here</a></h6>
    </div>
</div>

<?php require_once("includes/footer.php");?>
<script src="js/validate.js"></script>
<script src="js/ajaxify.js"></script>
<script src="js/alert.js"></script>
</body>
</html>