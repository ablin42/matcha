<?php
session_start();

define('APPROOT', dirname(__FILE__));
$t = explode("/",APPROOT);
$p = $t[sizeof($t) - 2];
$pathurl = "/".$p."/";
define('PATHURL', $pathurl);

unset($_SESSION['username']);
unset($_SESSION['id']);
unset($_SESSION['logged']);
session_destroy();
header('Location: '.$pathurl.'');