<?php
session_start();
use \ablin42\database;
use \ablin42\autoloader;
require ("../class/autoloader.php");
require_once("functions.php");
autoloader::register();
$db = database::getInstance('camagru');

if (!empty($_POST['id']) && !empty($_SESSION['id']))
{
    $attributes['id'] = secure_input($_POST['id']);
    $attributes['id_user'] = secure_input($_SESSION['id']);

    $db = database::getInstance('camagru');
    $req = $db->prepare("SELECT * FROM `image` WHERE `id` = :id AND `id_user` = :id_user", $attributes);
    if ($req)
    {
        $req = $db->prepare("DELETE FROM `image` WHERE `id` = :id", array('id' => $attributes['id']));
        echo alert_bootstrap("success", "Your picture has been successfully <b>deleted</b>!", "text-align: center;");
    }
    else
        echo alert_bootstrap("warning", "This picture is not yours or does not exist.", "text-align: center;");
}