<?php
session_start();
use \ablin42\database;
use \ablin42\autoloader;
require ("../class/autoloader.php");
require_once("functions.php");
autoloader::register();
$db = database::getInstance('camagru');

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['email']))
{
    $email = secure_input($_POST['email']);
    $pattern_email = "/^(([^<>()\[\]\\.,;:\s@\"]+(\.[^<>()\[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/";
    if (!check_length($email, 3, 255) || !preg_match($pattern_email, $email))
    {
        echo alert_bootstrap("warning", "Your <b>e-mail</b> has to be 3 characters minimum and 255 characters maximum! (and valid!)", "text-align: center;");
        return ;
    }

    $db = database::getInstance('camagru');
    $attributes1['email'] = $email;

    $req = $db->prepare("SELECT `id` FROM `user` WHERE `email` = :email", $attributes1);
    if ($req)
    {
        $user_id = null;
        foreach ($req as $item)
            $user_id = $item->id;
        if ($user_id === null)
        {
            echo alert_bootstrap("danger", "<b>Error:</b> There is no active account linked to this e-mail!", "text-align:center;");
            return;
        }
        $attributes2['password_token'] = gen_token(128);
        $attributes2['user_id'] = $user_id;
        $token = $attributes2['password_token'];

        $db->prepare("UPDATE `user` SET `password_token` = :password_token WHERE `id` = :user_id", $attributes2);
        mail($email, "Reset your password at Camagru", "In order to set a new password, please click this link: \n\nhttp://localhost:8080/Camagru/reset?id=$user_id&token=$token");
        echo alert_bootstrap("info", "An <b>e-mail</b> was sent to your adress, please follow the instructions we sent you.", "text-align:center;");
    }
    else
        echo alert_bootstrap("danger", "<b>Error:</b> There is no active account linked to this e-mail!", "text-align:center;");
}