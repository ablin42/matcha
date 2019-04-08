<?php
/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 4/08/19
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

        $req = $db->prepare("SELECT * FROM `notif` WHERE `user_id` = :id", $attributes);
        echo "".sizeof($req) . PHP_EOL."";
        echo "<div id='dropdown-notif-content' class='dropdown-notif-content'>";
        foreach ($req as $notif) {
            echo "<div onclick='removeNotif(this)' id='notif_".$notif->id."'><p>".$notif->body . PHP_EOL . $notif->date."</p></div>";
        }
        echo "</div>";
    }
}