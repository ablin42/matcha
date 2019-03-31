<?php
/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 3/26/19
 * Time: 6:13 PM
 */
session_start();
use \ablin42\database;
use \ablin42\autoloader;
require ("../class/autoloader.php");
require_once("../utils/functions.php");
autoloader::register();
$db = database::getInstance('matcha');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'));
    if (!empty($data->{'user_id'}) && !empty($_SESSION['id'])) {
        $attributes['reporter'] = secure_input($_SESSION['id']);
        $attributes['reported'] = secure_input($data->{'user_id'});

        $req = $db->prepare("SELECT * FROM `report` WHERE `id_reported` = :reporter AND `id_reported` = :reported", $attributes);
        if ($req) {
            echo alert_bootstrap("info" , "You already <b>reported</b> this user", "text-align: center;");
            return ;
        }
        $req = $db->prepare("INSERT INTO `report` (`id_reporter`, `id_reported`) VALUES (:reporter, :reported)", $attributes);
        echo alert_bootstrap("success" , "Your <b>report</b> has been registered", "text-align: center;");
    }
    else
        echo alert_bootstrap("warning" , "A <b>field</b> is empty", "text-align: center;");
}
else
    echo alert_bootstrap("danger" , "Not a <b>post</b> request.", "text-align: center;");
