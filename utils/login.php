<?php
session_start();
use \ablin42\database;
use \ablin42\autoloader;
require ("../class/autoloader.php");
require_once("functions.php");
autoloader::register();
$db = database::getInstance('camagru');

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['username_l']) && !empty($_POST['password_l']))
{
    $db = database::getInstance('camagru');

    $attributes_h['username'] =  htmlspecialchars(trim($_POST['username_l']));
    $pwd = hash('whirlpool', $_POST['password_l']);
    $req = $db->prepare("SELECT * FROM `user` WHERE `username` = :username", $attributes_h);
    if ($req)
    {
        foreach ($req as $elem)
        {
            if ($elem->confirmed_token !== NULL)
            {
                if ($elem->password === $pwd)
                {
                    $_SESSION['username'] = $elem->username;
                    $_SESSION['logged'] = 1;
                    $_SESSION['id'] = $elem->id;
                    echo alert_bootstrap("success", "You've been <b>logged in!</b>", "text-align: center;");
                    header('Refresh: 1; /Camagru/Glorify');
                }
                else
                    echo alert_bootstrap("warning", "Incorrect password!", "text-align: center;");
            }
            else
            {
                $subject = "Confirm your account at Camagru";
                $message = "In order to confirm your account, please click this link: \n\nhttp://localhost:8080/Camagru/utils/confirm.php?id=$elem->username&token=$elem->mail_token";
                mail($elem->email, $subject, $message);
                echo alert_bootstrap("info", "You did not <b>confirm your account</b> yet, we just sent you another <b>e-mail</b> to confirm your account.", "text-align: center;");
            }

        }
    }
    else
        echo alert_bootstrap("warning", "This user does not exist!", "text-align: center;");
}