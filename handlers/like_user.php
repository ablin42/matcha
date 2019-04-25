<?php
/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 3/27/19
 * Time: 3:35 PM
 */
session_start();
use \ablin42\autoloader;
use \ablin42\database;
require ("../class/autoloader.php");
require ("../utils/functions.php");
autoloader::register();
$db = database::getInstance('matcha');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'));
    if (!empty($data->{'user_id'}) && !empty($data->{'vote'}) && !empty($_SESSION['id'])) {
        $voter = secure_input($_SESSION['id']);
        $voted = secure_input($data->{'user_id'});
        $vote = secure_input($data->{'vote'});
        $req = $db->prepare("SELECT * FROM `user` WHERE `id` = :id", array("id" => $voted));
        if ($req) {
            $req = $db->prepare("SELECT * FROM `user` WHERE `id` = :id", array("id" => $voter));
            if ($req) {
                $attributes['voter'] = $voter;
                $attributes['voted'] = $voted;
                $username = ucfirst($req[0]->username);
                $notify['id'] = $voted;
                $notify['body'] = "<a onclick='notifRedirect(event, this);' href='profile?u=".urlencode($username)."'>".$username."</a> <b>liked</b> your profile";
                $notify['notifier'] = $voter;
                $like = $db->prepare("SELECT * FROM `vote` WHERE `id_voter` = :voted AND `id_voted` = :voter AND `type` = 1", $attributes);
                $attributes['vote'] = $vote;
                if ($like)
                    $notify['body'] = "<b>Match! </b><a href='/".$pathurl."/profile?u=".urlencode($username)."'>" . $username . "</a> <b>liked</b> your profile back! You can now <b>message eachother</b>!";
                if ($vote == 1 && is_notified($db, "like", $voter, $voted) === 0) {
                    $req = $db->prepare("INSERT INTO `notif` (`id_notifier`, `user_id`, `type`, `body`, `date`)
                                                   VALUES (:notifier, :id, 'like',:body, NOW())", $notify);
                }
                else if ($vote == 1 && is_notified($db, "like", $voter, $voted) === 1) {
                    $req = $db->prepare("UPDATE `notif` 
                                                   SET `date` = NOW(), `body` = :body 
                                                   WHERE `id_notifier` = :notifier 
                                                   AND `user_id` = :id 
                                                   AND `type` = 'like'", $notify);
                }
                if (has_voted($db, $voter, $voted, $vote) === 0)
                    $req = $db->prepare("INSERT INTO `vote` (`id_voter`, `id_voted`, `type`, `date`) 
                                                   VALUES (:voter, :voted, :vote, NOW())", $attributes);
                else if (has_voted($db, $voter, $voted, $vote) === 2) {
                    $req = $db->prepare("UPDATE `vote` 
                                                   SET `type` = :vote, `date` = NOW() 
                                                   WHERE `id_voter` = :voter 
                                                   AND `id_voted` = :voted", $attributes);
                    if ($vote == -1){
                        $db->prepare("DELETE FROM `notif` 
                                                WHERE `id_notifier` = :notifier 
                                                AND `user_id` = :user_id 
                                                AND `type` = 'like'",
                                                array("notifier" => $voter, "user_id" => $voted));
                        if ($like) {
                            $notify['body'] = "You matched with <a onclick='notifRedirect(event, this);' href='profile?u=".urlencode($username)."'>".$username."</a> but he <b>unliked</b> your profile... :(";
                            $db->prepare("INSERT INTO `notif` (`id_notifier`, `user_id`, `type`, `body`, `date`) 
                                                VALUES (:notifier, :id, 'like',:body, NOW())", $notify);
                        }
                    }
                }
                else {
                    array_pop($attributes);
                    $db->prepare("DELETE FROM `vote` WHERE `id_voter` = :voter AND `id_voted` = :voted", $attributes);
                    if ($like && $vote == 1) {
                        $notify['body'] = "You matched with <a onclick='notifRedirect(event, this);' href='profile?u=".urlencode($username)."'>" . $username . "</a> but he <b>unliked</b> your profile... :(";
                        $db->prepare("UPDATE `notif` 
                                                SET `body` = :body, `date` = NOW() 
                                                WHERE `id_notifier` = :notifier 
                                                AND `user_id` = :id
                                                AND `type` = 'like'", $notify);
                    }
                    else if (is_notified($db, "like", $voter, $voted) === 1 && $vote != -1)
                        $db->prepare("DELETE FROM `notif` WHERE `id_notifier` = :notifier AND `user_id` = :id AND `type` = 'like'", array("notifier" => $voter, "id" => $voted));
                    if ($vote == 1)
                        echo alert_bootstrap("info" , "You <b>unliked</b> this user!", "text-align: center;");
                    else if ($vote == -1)
                        echo alert_bootstrap("info" , "You <b>undisliked</b> this user!", "text-align: center;");
                    return;
                }
                if ($vote == 1)
                    echo alert_bootstrap("success" , "You <b>liked</b> this user!", "text-align: center;");
                else if ($vote == -1)
                    echo alert_bootstrap("info" , "You <b>disliked</b> this user!", "text-align: center;");
            }
            else {
                echo alert_bootstrap("warning" , "This <b>user</b> does not exist", "text-align: center;");
                return;
            }
        }
        else {
            echo alert_bootstrap("warning" , "This <b>user</b> does not exist", "text-align: center;");
            return;
        }
    }
    else
        echo alert_bootstrap("warning" , "A <b>field</b> is empty", "text-align: center;");
}
else
    echo alert_bootstrap("danger" , "Not a <b>post</b> request.", "text-align: center;");