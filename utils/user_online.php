<?php
/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 3/31/19
 * Time: 7:41 PM
 */
session_start();
use \ablin42\database;
use \ablin42\autoloader;
require ("../class/autoloader.php");
require ("../utils/functions.php");
autoloader::register();
$db = database::getInstance('matcha');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_SESSION['id'])) {
        $attributes['id'] = secure_input($_SESSION['id']);

        $req = $db->prepare("SELECT * FROM `user` WHERE `id` = :id", $attributes);
        if ($req) {
            $req = $db->prepare("UPDATE `user_info` SET `last_online` = NOW() WHERE `user_id` = :id", $attributes);
            return ;
        }
    }
}

