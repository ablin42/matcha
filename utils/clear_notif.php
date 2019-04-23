<?php
/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 4/08/19
 * Time: 9:41 PM
 */
session_start();
use \ablin42\database;
use \ablin42\autoloader;
require ("../class/autoloader.php");
require ("../utils/functions.php");
autoloader::register();
$db = database::getInstance('matcha');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'));
    if (!empty($_SESSION['id']) && !empty($data->{'notif'})) {
        $attributes['id'] = secure_input($_SESSION['id']);
        $attributes['id_notif'] = secure_input($data->{'notif'});
        $req = $db->prepare("SELECT * FROM `notif` WHERE `user_id` = :id AND `id` = :id_notif", $attributes);
        if ($req){
            $req = $db->prepare("DELETE FROM `notif` WHERE `user_id` = :id AND `id` = :id_notif", $attributes);
            echo alert_bootstrap("success" , "Notification <b>deleted</b>.", "text-align: center;");
        }
        else
            echo alert_bootstrap("info" , "This is not <b>your</b> notification or you're not logged in.", "text-align: center;");
    }
    else
        echo alert_bootstrap("warning" , "A <b>field</b> is empty", "text-align: center;");
}
else
    echo alert_bootstrap("danger" , "Not a <b>post</b> request.", "text-align: center;");