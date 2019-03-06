<?php
/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 3/6/19
 * Time: 11:18 PM
 */
session_start();
use \ablin42\database;
use \ablin42\autoloader;
require ("class/autoloader.php");
require_once("utils/functions.php");
autoloader::register();
$db = database::getInstance('matcha');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'));
    if (!empty($data->{'gender'}) && !empty($data->{'orientation'}) && !empty($data->{'bio'})) {
        $gender = secure_input($data->{'gender'});
        $orientation = secure_input($data->{'orientation'});
        $bio = secure_input($data->{'bio'});


        $attributes = array();
        $attributes['username'] = $username;

        $pattern_pw = "/^(((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))|((?=.*[A-Z])(?=.*[0-9])))(.{8,})/";
        $pattern_email = "/^(([^<>()\[\]\\.,;:\s@\"]+(\.[^<>()\[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/";
        if (!check_length($username, 4, 30)) {
            echo alert_bootstrap("warning", "Your <b>username</b> has to be 4 characters minimum and 30 characters maximum!", "text-align: center;");
            return ;
        }

        else if (!check_length($password,8, 30) || !check_length($password2,8, 30) || (!preg_match($pattern_pw, $password))) {
            echo alert_bootstrap("warning", "Your <b>password</b> has to be 8 characters, 30 characters maximum and has to be atleast alphanumeric!", "text-align: center;");
            return ;
        }

        else if (!check_length($email, 3, 255) || !preg_match($pattern_email, $email)) {
            echo alert_bootstrap("warning", "Your <b>e-mail</b> has to be 3 characters minimum and 255 characters maximum! (and valid!)", "text-align: center;");
            return ;
        }

        $req = $db->prepare("SELECT * FROM `user` WHERE `username` = :username", $attributes);
        if ($req) {
            echo alert_bootstrap("warning", "The <b>username</b> you entered is already taken, <b>please pick another one.</b>", "text-align: center;");
            return ;
        }

        $attributes['email'] = $email;
        $attributes['password'] = hash('whirlpool', $password);

        $req = $db->prepare("SELECT * FROM `user` WHERE `email` = :email", array('email' => $email));
        if ($req) {
            echo alert_bootstrap("warning" , "The <b>e-mail</b> you entered is already taken, <b>please pick another one.</b>", "text-align: center;");
            return ;
        }

        $token = gen_token(128);
        $attributes['mail_token'] = $token;

        $db->prepare("INSERT INTO `user` (`username`, `password`, `email`, `mail_token`) VALUES (:username, :password, :email, :mail_token)", $attributes);
        $user_id = $db->lastInsertedId();

        echo alert_bootstrap("success", "<b>Your infos has been <b>successfully updated</b>!", "text-align: center;");
    }
    else
        alert_bootstrap("warning" , "A <b>field</b> is empty", "text-align: center;");
}
else
    alert_bootstrap("danger" , "Not a <b>post</b> request.", "text-align: center;");
