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

        $req = $db->prepare("SELECT * FROM `notif` WHERE `user_id` = :id ORDER BY `date` DESC", $attributes);
        $block = $db->prepare("SELECT * FROM `block` WHERE `id_blocker` = :id", $attributes);

        $count = 0;
        foreach ($req as $notif) {
            $blocked = 0;
            foreach ($block as $b) {
                if ($b->id_blocked === $notif->id_notifier)
                    $blocked = 1;
            }
            if ($blocked === 0)
            {
                echo "<div onclick=\"removeNotif(this)\" id=\"notif_".$notif->id."\"><p>".$notif->body . " " . $notif->date."</p></div>";
                $count++;
            }
        }
        echo PHP_EOL .$count;
    }
}