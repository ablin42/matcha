<?php
/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 3/20/19
 * Time: 9:53 PM
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
    if (!empty($data->{'photoid'}) && !empty($_SESSION['id'])) {
        $attributes['id'] = secure_input($_SESSION['id']);
        $photo = "photo" . secure_input($data->{'photoid'});
        $req = $db->prepare("SELECT $photo FROM `user_photo` WHERE `user_id` = :id", $attributes);
        if ($req) {
            foreach ($req as $item){
                $photopath = "../" . $item->$photo;
            }
        }
        else {
            echo alert_bootstrap("warning", "You did not upload any picture yet.", "text-align: center;");
            return;
        }
        $req = $db->prepare("UPDATE `user_photo` SET $photo = NULL WHERE `user_id` = :id", $attributes);
        if ($req){
            echo alert_bootstrap("warning", "You did not upload any picture yet.", "text-align: center;");
            return;
       }
        else {
            echo alert_bootstrap("success", "Your picture has been successfully <b>deleted</b>!", "text-align: center;");
            if ($photopath !== NULL)
                unlink($photopath);
        }
    }
    else
        echo alert_bootstrap("warning" , "A <b>field</b> is empty", "text-align: center;");
}
else
    echo alert_bootstrap("danger" , "Not a <b>post</b> request.", "text-align: center;");
