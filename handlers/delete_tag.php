<?php
/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 3/25/19
 * Time: 5:45 PM
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
    if (!empty($data->{'tag'}) && !empty($_SESSION['id'])) {
        $attributes['id'] = secure_input($_SESSION['id']);
        $attributes['tag'] = $data->{'tag'};
        $req = $db->prepare("DELETE FROM `user_tags` WHERE `user_id` = :id AND `tag` = :tag", $attributes);
        echo alert_bootstrap("success", "Your tag has been successfully <b>deleted</b>!", "text-align: center;");
    }
    else
        alert_bootstrap("warning" , "A <b>field</b> is empty", "text-align: center;");
}
else
    alert_bootstrap("danger" , "Not a <b>post</b> request.", "text-align: center;");
