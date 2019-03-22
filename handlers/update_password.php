<?php
/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 3/22/19
 * Time: 8:15 PM
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
    if (!empty($data->{'currpw'}) && !empty($data->{'password'}) && !empty($data->{'password2'})) {
        $currpassword = $data->{'currpw'};
        $password = $data->{'password'};
        $password2 = $data->{'password2'};
        $pattern_pw = "/^(((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(.{8,})/";
        if (!check_length($password, 8, 30) || !check_length($password2, 8, 30) || (!preg_match($pattern_pw, $password))) {
            echo alert_bootstrap("warning", "Your <b>password</b> has to be 8 characters, 30 characters maximum and has to be atleast alphanumeric!", "text-align: center;");
            return;
        }
        $attributes['user_id'] = secure_input($_SESSION['id']);
        $req = $db->prepare("SELECT * FROM `user` WHERE `id` = :user_id", $attributes);
        if (!$req) {
            echo alert_bootstrap("danger", "Error: User not found. Please try again. If the error persist try disconnecting and reconnecting", "text-align: center;");
            return;
        } else {
            if ($password === $password2) {
                $currpw = hash('whirlpool', $currpassword);
                foreach ($req as $item) {
                    if ($item->password !== $currpw) {
                        echo alert_bootstrap("danger", "<b>Error:</b> This is not your current password.", "text-align: center;");
                        return;
                    }
                }
                $attributes['password'] = hash('whirlpool', $password);
                $req = $db->prepare("UPDATE `user` SET `password` = :password WHERE `id` = :user_id", $attributes);
                echo alert_bootstrap("success", "<b>Congratulations !</b> You successfully changed your password!", "text-align: center;");
                return;
            }
            else
                echo alert_bootstrap("danger", "<b>Error:</b> The passwords you entered didn't match.", "text-align: center;");
        }
    }
}