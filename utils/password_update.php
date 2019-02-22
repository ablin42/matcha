<?php
session_start();
use \ablin42\database;
use \ablin42\autoloader;
require ("../class/autoloader.php");
require_once("functions.php");
autoloader::register();
$db = database::getInstance('camagru');

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['id_user']) && !empty($_POST['token'])&& !empty($_POST['password']) && !empty($_POST['password2']))
{
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $id = (int) secure_input($_POST['id_user']);
    $token = secure_input($_POST['token']);
    if ($password === $password2)
    {
        $pattern_pw = "/^(((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(.{8,})/";
        if (!check_length($password,8, 30) || !check_length($password2,8, 30) || (!preg_match($pattern_pw, $password)))
        {
            echo alert_bootstrap("warning", "Your <b>password</b> has to be 8 characters, 30 characters maximum and has to be atleast alphanumeric!", "text-align: center;");
            return;
        }
        $attributes['id'] = $id;
        $db = database::getInstance('camagru');
        $req = $db->prepare("SELECT `password_token` FROM `user` WHERE `id` = :id", $attributes);
        if ($req) {
            $attributes['password'] = hash("whirlpool", $password);
            foreach ($req as $item) {
                if ($item->password_token === $token) {
                    $db->prepare("UPDATE `user` SET `password_token` = NULL, `password` = :password WHERE `id` = :id", $attributes);
                    echo alert_bootstrap("success", "<b>Congratulations!</b> Your password has been changed! Please, log in.", "text-align: center;");
                }
                else
                    echo alert_bootstrap("danger", "<b>Invalid token!</b> Please, click the link we sent at your <b>e-mail</b>.", "text-align: center");
            }
        }
        else
            echo alert_bootstrap("danger", "This user or token does not exist or is invalid, please <b>click the link that was sent at your e-mail address.</b>", "text-align: center;");
    }
    else
        echo alert_bootstrap("danger", "<b>The passwords you entered didn't match.</b>", "text-align: center;");}
