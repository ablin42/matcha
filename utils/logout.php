<?php
session_start();
unset($_SESSION['username']);
unset($_SESSION['id']);
unset($_SESSION['logged']);
session_destroy();
header('Location: /Camagru/');