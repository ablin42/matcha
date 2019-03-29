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

    $attributes['reporter'] = secure_input($_SESSION['id']);
    $attributes['reported'] = $id;
    $report = false;
    $req = $db->prepare("SELECT * FROM `report` WHERE `reporter_id` = :reporter AND `reported_id` = :reported", $attributes);
    if ($req)
        $report = true;

    $req = $db->prepare("SELECT SUM(`type`) as sum, COUNT(*) as total FROM `vote` WHERE `id_voted` = :voted", array("voted" => $id));
    if ($req) {
        $sum = $req[0]->sum;
        $nbvote = $req[0]->total;
        $score = $sum * $nbvote;
    }
    else
        $score = 0;

    $req = $db->prepare("SELECT * FROM `visit` WHERE `id_visitor` = :reporter AND `id_visited` = :reported", $attributes);
    if ($req) {
        $req = $db->prepare("UPDATE `visit` SET `date` = NOW() WHERE `id_visitor` = :reporter AND `id_visited` = :reported", $attributes);
    }
    else
        $req = $db->prepare("INSERT INTO `visit` (`id_visitor`, `id_visited`, `date`) VALUES (:reporter, :reported, NOW())", $attributes);
}
