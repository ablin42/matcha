<?php
session_start();
use \ablin42\bootstrapForm;
use \ablin42\autoloader;

require_once ("class/autoloader.php");
require_once ("utils/functions.php");
autoloader::register();
$form = new bootstrapForm();
$form->changeSurr('div class="form-group"', 'div');
?>
<script src="js/ajaxify.js"></script>
<nav class="navbar navbar-expand-lg" id="header">
<div class="container-fluid">
    <a class="navbar-brand" href="/Camagru">Home</a>


    <div class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="far fa-user"></i>
        <div class="dropdown-content">
            <ul class="nav navbar-nav navbar-right ml-auto">
                <?php
                if (isset($_SESSION['logged']) && isset($_SESSION['username'])) {
                    echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"account\">{$_SESSION['username']}</a></li>";
                    echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"glorify\">Take pictures !</a></li>";
                }
                ?>
                <form name="login_dropdown" class="form" action="" method="post">
                    <?php
                    if (!isset($_SESSION['logged']))
                    {
                        $form->setLabel('Username', 'lab');
                        echo $form->input('username_l', 'username_l-sm', "form-control form-dropdown", "ablin42");
                        $form->setLabel('Password', 'lab');
                        echo $form->password('password_l', 'password_l-sm', "form-control form-dropdown", "********");
                        echo $form->submit('submit_login', 'submit_login-sm', 'btn btn-outline-warning', 'Log in');
                    }
                    ?>
                </form>
                <?php
                if (!isset($_SESSION['logged']))
                {
                    echo '<li class="nav-item"><a class="nav-link" href="lostpassword">Forgot your password?</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="register">Sign up</a></li>';
                }
                else
                    echo '<li class="nav-item"><a class="nav-link" href="utils/logout.php">Logout</a></li>';
                ?>
            </ul>
        </div>
    </div>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="nav navbar-nav navbar-right ml-auto">
            <?php
                if (isset($_SESSION['logged']) && isset($_SESSION['username'])) {
                    echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"account\">{$_SESSION['username']}</a></li>";
                    echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"glorify\">Take pictures !</a></li>";
                }
            ?>
            <form onsubmit="return submitForm(this, 'login');" name="login" class="form-inline my-2 my-lg-0" action="" method="post">
                <?php
                    if (!isset($_SESSION['logged']))
                    {
                        $form->setLabel('Username', 'lab mr-2 ml-2');
                        echo $form->input('username_l', 'username_l', "form-control", "ablin42");
                        $form->setLabel('Password', 'lab mr-2 ml-2');
                        echo $form->password('password_l', 'password_l', "form-control", "********");
                        echo $form->submit('submit_login', 'submit_login', 'btn btn-outline-warning my-2 my-sm-0 ml-2', 'Log in');
                    }
                ?>
            </form>
            <?php
                if (!isset($_SESSION['logged']))
                {
                    echo '<li class="nav-item"><a class="nav-link" href="lostpassword">Forgot your password?</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="register">Sign up</a></li>';
                }
                else
                    echo '<li class="nav-item"><a class="nav-link" href="utils/logout.php">Logout</a></li>';
                ?>
        </ul>
    </div>
</div>
</nav>