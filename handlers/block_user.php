<?php
/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 3/31/19
 * Time: 5:10 PM
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
        $attributes['blocker'] = secure_input($_SESSION['id']);
        $attributes['blocked'] = secure_input($data->{'user_id'});

        $req = $db->prepare("SELECT * FROM `block` WHERE `id_blocker` = :blocker AND `id_blocked` = :blocked", $attributes);
        if ($req) {
            $req = $db->prepare("DELETE FROM `block` WHERE `id_blocker` = :blocker AND `id_blocked` = :blocked", $attributes);
            echo alert_bootstrap("info" , "You <b>unblocked</b> this user", "text-align: center;");
            return ;
        }
        $req = $db->prepare("INSERT INTO `block` (`id_blocker`, `id_blocked`) VALUES (:blocker, :blocked)", $attributes);
        echo alert_bootstrap("success" , "You <b>blocked</b> this user", "text-align: center;");
    }
    else
        echo alert_bootstrap("warning" , "A <b>field</b> is empty", "text-align: center;");
}
else
    echo alert_bootstrap("danger" , "Not a <b>post</b> request.", "text-align: center;");
