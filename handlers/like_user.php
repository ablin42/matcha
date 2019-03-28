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
                $attributes['vote'] = $vote;
                if (has_voted($db, $voter, $voted, $vote) === 0)
                    $req = $db->prepare("INSERT INTO `vote` (`id_voter`, `id_voted`, `type`, `date`) VALUES (:voter, :voted, :vote, NOW())", $attributes);
                else if (has_voted($db, $voter, $voted, $vote) === 2)
                    $req = $db->prepare("UPDATE `vote` SET `type` = :vote, `date` = NOW() WHERE `id_voter` = :voter AND `id_voted` = :voted", $attributes);
                else{
                    array_pop($attributes);
                    $req = $db->prepare("DELETE FROM `vote` WHERE `id_voter` = :voter AND `id_voted` = :voted", $attributes);
                    echo alert_bootstrap("info" , "Your <b>vote</b> has been <b>deleted!</b>", "text-align: center;");
                    return;
                }
                echo alert_bootstrap("success" , "Your <b>vote</b> has been <b>registered!</b>", "text-align: center;");
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