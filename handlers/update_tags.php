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
    if (!empty($data->{'tags'})) {
        $attributes = array();
        $attributes['user_id'] = secure_input($_SESSION['id']);
        $req = $db->prepare("SELECT * FROM `user` WHERE `id` = :user_id", $attributes);
        if (!$req) {
            echo alert_bootstrap("danger", "Error: User not found. Please try again. If the error persist try disconnecting and reconnecting", "text-align: center;");
            return;
        }
        foreach ($data->tags as $tag)
        {
            $attributes['tag'] = secure_input($tag);
            $req = $db->prepare("SELECT * FROM `user_tags` WHERE `user_id` = :user_id AND `tag` = :tag", $attributes);
            if (!$req) {
                $req = $db->prepare("INSERT INTO `user_tags` (`user_id`, `tag`) VALUES (:user_id, :tag)", $attributes);
                if ($req) {
                    echo alert_bootstrap("danger", "Error: tag update failed, please try again", "text-align: center;");
                    return;
                }
            }
        }
        echo alert_bootstrap("success", "Your tags has been <b>successfully updated</b>!", "text-align: center;");
    }
    else
        alert_bootstrap("warning" , "A <b>field</b> is empty", "text-align: center;");
}
else
    alert_bootstrap("danger" , "Not a <b>post</b> request.", "text-align: center;");
