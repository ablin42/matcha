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
    $score = 0;
    $req = $db->prepare("SELECT * FROM `user` WHERE `username` = :username", array("username" => $username));
    if ($req) {
        foreach ($req as $item) {
            $id = $item->id;
            $username = ucwords($item->username);
            $email = $item->email;
        }
    }
    else {
        header('Location: /Matcha/Account?e=pro');
        return;
    }
    if ($id === $_SESSION['id']){
        header('Location: /Matcha/Account');
        return;
    }
    $req = $db->prepare("SELECT * FROM `user_info` WHERE `user_id` = :user_id", array("user_id" => $id));
    if ($req) {
        foreach ($req as $item) {
            $gender = $item->gender;
            $orientation = $item->orientation;
            $bio = $item->bio;
            $firstname = $item->firstname;
            $lastname = $item->lastname;
            $birth_year = date("Y") - $item->birth_year;
            $lastonline = $item->last_online;
        }
    }

    $datetime1 = new DateTime('', new DateTimeZone('Europe/Paris'));
    $datetime2 = new DateTime($lastonline, new DateTimeZone('Europe/Paris'));
    $interval = $datetime2->diff($datetime1);
    $status = "<p style='color:green'><b>Online</b></p>";
    if ($interval->y > 1 || $interval->m > 1 || $interval->d > 1 || $interval->h > 1 || $interval->i >= 5)
        $status = "Last time seen <b>online</b>: <i>$lastonline</i>";

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

    $req = $db->prepare("SELECT * FROM `user_photo` WHERE `user_id` = :user_id", array("user_id" => secure_input($_SESSION['id'])));
    if ($req) {
        $photos_curr_user = array();
        foreach ($req as $item) {
            for ($i = 1; $i < 6; $i++) {
                $photonb = "photo" . $i;
                array_push($photos_curr_user, $item->$photonb);
            }
        }
    }

    $attributes['reporter'] = secure_input($_SESSION['id']);
    $attributes['reported'] = $id;
    $report = false;
    $req = $db->prepare("SELECT * FROM `report` WHERE `id_reporter` = :reporter AND `id_reported` = :reported", $attributes);
    if ($req)
        $report = true;

    $block = "Block user";
    $req = $db->prepare("SELECT * FROM `block` WHERE `id_blocker` = :reporter AND `id_blocked` = :reported", $attributes);
    if ($req)
        $block = "Unblock user";

    $req = $db->prepare("SELECT SUM(`type`) as sum, COUNT(*) as total FROM `vote` WHERE `id_voted` = :voted", array("voted" => $id));
    if ($req) {
        $sum = $req[0]->sum;
        $nbvote = $req[0]->total;
        $score = $sum * $nbvote;
    }

    $req = $db->prepare("SELECT COUNT(*) AS nbvisit FROM `visit` WHERE `id_visited` = :user_id", array("user_id" => $id), true);
    if ($req)
        $score += ($req->nbvisit * $nbvote);

    $req = $db->prepare("SELECT * FROM `visit` WHERE `id_visitor` = :reporter AND `id_visited` = :reported", $attributes);
    if ($req) {
        $req = $db->prepare("UPDATE `visit` SET `date` = NOW() WHERE `id_visitor` = :reporter AND `id_visited` = :reported", $attributes);
    }
    else
        $req = $db->prepare("INSERT INTO `visit` (`id_visitor`, `id_visited`, `date`) VALUES (:reporter, :reported, NOW())", $attributes);

    $notify['user_id'] = $id;
    $notify['notifier'] = secure_input($_SESSION['id']);
    $visitor_name = secure_input($_SESSION['username']);
    $notify['body'] = "<a onclick='notifRedirect(event, this);' href='profile?u=".$visitor_name."'>".$visitor_name."</a> <b>visited</b> your profile";
    if (is_notified($db, "visit", $notify['notifier'], $notify['user_id']) === 0)
        $db->prepare("INSERT INTO `notif` (`id_notifier`, `user_id`, `type`, `body`, `date`) VALUES (:notifier, :user_id, 'visit',:body, NOW())", $notify);
    else if (is_notified($db, "visit", $notify['notifier'], $notify['user_id']) === 1) {
        $db->prepare("UPDATE `notif` SET `date` = NOW(), `body` = :body WHERE `type` = 'visit' AND `id_notifier` = :notifier AND `user_id` = :user_id", $notify);
    }

    $req = $db->prepare("SELECT * FROM `user_location` WHERE `user_id` = :user_id", array("user_id" => secure_input($_SESSION['id'])), true);
    if ($req) {
        $attributes_loc['lat1'] = $req->lat;
        $attributes_loc['lng1'] = $req->lng;
    }
    else
        $error_dist = 1;

    $req = $db->prepare("SELECT * FROM `user_location` WHERE `user_id` = :user_id", array("user_id" => $id), true);
    if ($req) {
        $attributes_loc['lat2'] = $req->lat;
        $attributes_loc['lng2'] = $req->lng;
    }
    else
        $error_dist = 1;

    if ($error_dist != 1)
        $distance = round(distance($attributes_loc['lat1'], $attributes_loc['lng1'], $attributes_loc['lat2'], $attributes_loc['lng2'], "K"));

    if (has_voted($db, secure_input($id), secure_input($_SESSION['id']), 1) === 1 && has_voted($db, secure_input($_SESSION['id']),secure_input($id), 1) === 1) {
        $user1 = $id;
        $user2 = secure_input($_SESSION['id']);
        if ($user2 > $user1)
            swap($user2, $user1);
        $roomid = substr("".hash('whirlpool', $user1)."".hash('whirlpool', $user2)."", 120, 50);
        $chat['roomid'] = $roomid;
        $req = $db->prepare("SELECT * FROM `chatroom` WHERE `roomid` = :roomid", $chat);
        if (!$req){
            $chat['user1_id'] = $user1;
            $chat['user2_id'] = $user2;
            $req = $db->prepare("INSERT INTO `chatroom` (`roomid`, `user1_id`, `user2_id`) VALUES (:roomid, :user1_id, :user2_id)", $chat);
        }
    }
}
else
    header('Location: /Matcha/Account?e=pro');
