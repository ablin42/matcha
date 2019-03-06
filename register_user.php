<?php
/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 2/26/19
 * Time: 8:29 PM
 **/
session_start();
use \ablin42\database;
use \ablin42\autoloader;
require ("class/autoloader.php");
require_once("utils/functions.php");
autoloader::register();
$db = database::getInstance('matcha');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'));
    if (!empty($data->{'username'}) && !empty($data->{'email'}) && !empty($data->{'password'}) && !empty($data->{'password2'})) {
        $username = secure_input($data->{'username'});
        $email = secure_input($data->{'email'});
        $password = $data->{'password'};
        $password2 = $data->{'password2'};
        if ($password === $password2)
        {
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

            $subject = "Confirm your account at Matcha";
            $message = "In order to confirm your account, please click this link: \n\nhttp://localhost:8080/Matcha/utils/confirm_account.php?id=$user_id&token=$token";
            mail($email, $subject, $message);
            echo alert_bootstrap("success", "<b>Your account has been successfully created!</b> Please <b>confirm your email</b> by clicking the link we sent at your e-mail address", "text-align: center;");
        }
        else
            echo alert_bootstrap("danger", "<b>The passwords you entered didn't match.</b>", "text-align: center;");
    }
    else
        alert_bootstrap("warning" , "A <b>field</b> is empty", "text-align: center;");
}
else
    alert_bootstrap("danger" , "Not a <b>post</b> request.", "text-align: center;");
