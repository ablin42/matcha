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
    <a class="navbar-brand" href="/Matcha">Home</a>


    <div class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="far fa-user"></i>
        <div class="dropdown-content">
            <ul class="nav navbar-nav navbar-right ml-auto">
                <?php
                if (isset($_SESSION['logged']) && isset($_SESSION['username'])) {
                    echo "<li class=\"nav-item\"><i id='dropdownnotif' class=\"far fa-bell fa-2x\"></i></li>";
                    echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"search\">Search</a></li>";
                    echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"suggestion\">Suggestions</a></li>";
                    echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"activity\">Activity</a></li>";
                    echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"account\">".ucwords($_SESSION['username'])."</a></li>";
                }
                ?>
                <?php
                if (!isset($_SESSION['logged']))
                {
                    echo '<li class="nav-item"><a class="nav-link" href="index">Log in/Sign up</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="lostpassword">Forgot your password?</a></li>';
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
                    echo "<div id=\"dropdown-notif\" class='dropdown'><li class=\"nav-item\"><p id='nbnotif'></p><a href='#' id='dropdown-menu-notif' onclick='dropDown()' class='dropbtn'><i id='notif' class=\"far fa-bell fa-2x\"></i></a></li></div>";
                    echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"search\">Search</a></li>";
                    echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"suggestion\">Suggestions</a></li>";
                    echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"activity\">Activity</a></li>";
                    echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"account\">".ucwords($_SESSION['username'])."</a></li>";
                }
            ?>
            <?php
                if (!isset($_SESSION['logged']))
                {
                    echo '<li class="nav-item"><a class="nav-link" href="index">Log in/Sign up</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="lostpassword">Forgot your password?</a></li>';
                }
                else
                    echo '<li class="nav-item"><a class="nav-link" href="utils/logout.php">Logout</a></li>';
                ?>
        </ul>
    </div>
</div>
</nav>