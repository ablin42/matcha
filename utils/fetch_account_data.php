<?php
/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 3/20/19
 * Time: 7:33 PM
 */
use \ablin42\database;
$db = database::getInstance('matcha');

if ($_SESSION['id']) {
    $id = secure_input($_SESSION['id']);

    $req = $db->prepare("SELECT * FROM `user_info` WHERE `user_id` = :user_id", array("user_id" => $id));
    if ($req) {
        foreach ($req as $item) {
            $gender = $item->gender;
            $orientation = $item->orientation;
            $bio = $item->bio;
            $firstname = $item->firstname;
            $lastname = $item->lastname;
        }
    }

    $req = $db->prepare("SELECT `tag` FROM `user_tags` WHERE `user_id` = :user_id", array("user_id" => $id));
    if ($req) {
        $tags = array();
        foreach ($req as $item) {
            array_push($tags, $item->tag);
        }
        $tags = json_encode($tags);
    }

    $req = $db->prepare("SELECT * FROM `user_photo` WHERE `user_id` = :user_id", array("user_id" => $id));
    if ($req) {
        $photos = array();
        foreach ($req as $item) {
            for ($i = 1; $i < 6; $i++) {
                $photonb = "photo" . $i;
                array_push($photos, json_encode($item->$photonb));
            }
        }
    }

    $req = $db->prepare("SELECT * FROM `user` WHERE `id` = :user_id", array("user_id" => $id));
    if ($req) {
        foreach ($req as $item) {
            $username = $item->username;
            $email = $item->email;
        }
    }
    $lat = 48.856783210696854;
    $lng = 2.345733642578125;
    $req = $db->prepare("SELECT * FROM `user_location` WHERE `user_id` = :user_id", array("user_id" => $id), true);
    if ($req) {
        $lat = $req->lat;
        $lng = $req->lng;
    }
}