<?php
/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 3/18/19
 * Time: 9:59 PM
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
    if (!empty($data->{'lat'}) && !empty($data->{'lng'})) {
        $lat = (float)secure_input($data->{'lat'});
        $lng = (float)secure_input($data->{'lng'});
        if (is_float($lat) && is_float($lng) && $lat != 0 && $lng != 0) {
            $attributes['user_id'] = secure_input($_SESSION['id']);
            $req = $db->prepare("SELECT * FROM `user` WHERE `id` = :user_id", $attributes);
            if (!$req) {
                echo alert_bootstrap("danger", "Error: User not found. Please try again. If the error persist try disconnecting and reconnecting", "text-align: center;");
                return;
            }
            $req = $db->prepare("SELECT * FROM `user_location` WHERE `user_id` = :user_id", $attributes);
            $attributes['lat'] = $lat;
            $attributes['lng'] = $lng;
            if ($req)
                $req = $db->prepare("UPDATE `user_location` SET `lat` = :lat, `lng` = :lng WHERE `user_id` = :user_id", $attributes);
            else
                $req = $db->prepare("INSERT INTO `user_location` (`user_id`, `lat`, `lng`) VALUES (:user_id, :lat, :lng)", $attributes);

            echo alert_bootstrap("success", "Your <b>location</b> has been <b>successfully updated</b>!", "text-align: center;");
        }
        else
            echo alert_bootstrap("warning" , "Please, fill the <b>fields</b> properly.", "text-align: center;");
    }
    else
        echo alert_bootstrap("warning" , "A <b>field</b> is empty", "text-align: center;");
}
else
    echo alert_bootstrap("danger" , "Not a <b>post</b> request.", "text-align: center;");
