<?php
use \ablin42\database;
use \ablin42\autoloader;
require ("../class/autoloader.php");
require ("functions.php");
autoloader::register();


if (isset($_GET['id']) && isset($_GET['token']) && !empty($_GET['id']) && !empty($_GET['token']))
{
    $attributes['user_id'] = secure_input($_GET['id']);

    $db = database::getInstance('matcha');
    $req = $db->prepare("SELECT `mail_token` FROM `user` WHERE `id` = :user_id", $attributes, true);{
        if ($req->mail_token === secure_input($_GET['token']))
            $db->prepare("UPDATE `user` SET `mail_token` = 'NULL', `confirmed_token` = NOW() WHERE `id` = :user_id", $attributes);
    }
}
echo "<script>window.close();</script>";