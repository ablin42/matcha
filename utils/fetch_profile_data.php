<?php
/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 3/25/19
 * Time: 7:00 PM
 */
use \ablin42\database;
$db = database::getInstance('matcha');

if (!empty($_GET['u'])) {
    $username = secure_input($_GET['u']);
    $req = $db->prepare("SELECT * FROM `user` WHERE `username` = :username", array("username" => $username));
    if ($req) {
        foreach ($req as $item) {
            $id = $item->id;
            $username = $item->username;
            $email = $item->email;
        }
    }
    else
        header('Location: /Matcha?e=pro');
    $req = $db->prepare("SELECT * FROM `user_info` WHERE `user_id` = :user_id", array("user_id" => $id));
    if ($req) {
        foreach ($req as $item) {
            $gender = $item->gender;
            $orientation = $item->orientation;
            $bio = $item->bio;
            $firstname = $item->firstname;
            $lastname = $item->lastname;
            $birth_year = $item->birth_year;
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
                array_push($photos, $item->$photonb);
            }
        }
    }
}
