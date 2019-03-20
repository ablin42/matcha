<?php
/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 3/20/19
 * Time: 7:33 PM
 */
use \ablin42\database;
$db = database::getInstance('matcha');
$req = $db->prepare("SELECT * FROM `user_info` WHERE `user_id` = :user_id", array("user_id" => secure_input($_SESSION['id'])));
if ($req) {
    foreach ($req as $item) {
        $gender = $item->gender;
        $orientation = $item->orientation;
        $bio = $item->bio;
    }
}

$req = $db->prepare("SELECT `tag` FROM `user_tags` WHERE `user_id` = :user_id", array("user_id" => secure_input($_SESSION['id'])));
if ($req) {
    $tags = array();
    foreach ($req as $item) {
        array_push($tags, $item->tag);
    }
    $tags = json_encode($tags);
}

$req = $db->prepare("SELECT * FROM `user_photo` WHERE `user_id` = :user_id", array("user_id" => secure_input($_SESSION['id'])));
if ($req) {
    $photos = array();
    foreach ($req as $item) {
        for ($i = 1; $i < 6; $i++){
            $photonb = "photo" . $i;
            array_push($photos, json_encode($item->$photonb));
        }
    }
}

