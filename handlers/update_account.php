<?php
/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 3/22/19
 * Time: 5:55 PM
 */
session_start();
use \ablin42\database;
use \ablin42\autoloader;
require ("../class/autoloader.php");
require_once("../utils/functions.php");
autoloader::register();
$db = database::getInstance('matcha');

require_once("../utils/pathinfo.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'));
    if (!empty($data->{'firstname'}) && !empty($data->{'lastname'}) && !empty($data->{'username'}) && !empty($data->{'email'})) {
        $firstname = secure_input($data->{'firstname'});
        $lastname = secure_input($data->{'lastname'});
        $username = secure_input($data->{'username'});
        $email = secure_input($data->{'email'});
        $user_id = secure_input($_SESSION['id']);
        $attributes_info['user_id'] = $user_id;
        $attributes_info['firstname'] = ucfirst($firstname);
        $attributes_info['lastname'] = ucfirst($lastname);
        $attributes['username'] = $username;

        $pattern_email = "/^(([^<>()\[\]\\.,;:\s@\"]+(\.[^<>()\[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/";
        if (!check_length($firstname, 2, 16)) {
            echo alert_bootstrap("warning", "Your <b>firstname</b> has to be 2 characters minimum and 16 characters maximum!", "text-align: center;");
            return ;
        }
        if (!check_length($lastname, 2, 16)) {
            echo alert_bootstrap("warning", "Your <b>lastname</b> has to be 2 characters minimum and 16 characters maximum!", "text-align: center;");
            return ;
        }
        if (!check_length($username, 4, 30)) {
            echo alert_bootstrap("warning", "Your <b>username</b> has to be 4 characters minimum and 30 characters maximum!", "text-align: center;");
            return ;
        }
        else if (!check_length($email, 3, 255) || !preg_match($pattern_email, $email)) {
            echo alert_bootstrap("warning", "Your <b>e-mail</b> has to be 3 characters minimum and 255 characters maximum! (and valid!)", "text-align: center;");
            return ;
        }

        $req = $db->prepare("SELECT * FROM `user` WHERE `username` = :username", $attributes);
        if ($req && $req[0]->id != $user_id) {
            echo alert_bootstrap("warning", "The <b>username</b> you entered is already taken, <b>please pick another one.</b>", "text-align: center;");
            return ;
        }

        $attributes['email'] = $email;
        $req = $db->prepare("SELECT * FROM `user` WHERE `email` = :email", array('email' => $email));

        if ($req && $req[0]->id != $user_id) {
            echo alert_bootstrap("warning" , "The <b>e-mail</b> you entered is already taken, <b>please pick another one.</b>", "text-align: center;");
            return ;
        }
        else if ($req && $req[0]->id == $user_id) {
            $attributes2['user_id'] = $user_id;
            $attributes2['username'] = $username;
            $req = $db->prepare("UPDATE `user` SET `username` = :username WHERE `id` = :user_id", $attributes2);
            $db->prepare("UPDATE `user_info` SET `firstname` = :firstname, `lastname` = :lastname WHERE `user_id` = :user_id", $attributes_info);
            echo alert_bootstrap("success", "<b>Your account informations has been successfully updated!</b>", "text-align: center;");
        }
        else {
            $token = gen_token(128);
            $attributes['mail_token'] = $token;
            $attributes['user_id'] = $user_id;
            $db->prepare("UPDATE `user` SET `username` = :username, `email` = :email, `mail_token` = :mail_token, `confirmed_token` = NULL WHERE `id` = :user_id", $attributes);
            $db->prepare("UPDATE `user_info` SET `firstname` = :firstname, `lastname` = :lastname WHERE `user_id` = :user_id", $attributes_info);

            $subject = "Confirm your email at Matcha";
            $message = "In order to confirm your account, please click this link: \n\nhttp://localhost:8080/$pathurl/utils/confirm_account.php?id=$user_id&token=$token";
            mail($email, $subject, $message);
            echo alert_bootstrap("success", "<b>Your account informations has been successfully updated!</b> Please <b>confirm your email</b> by clicking the link we sent at your new e-mail address", "text-align: center;");
        }
    }
    else
        echo alert_bootstrap("warning" , "A <b>field</b> is empty", "text-align: center;");
}
else
    echo alert_bootstrap("danger" , "Not a <b>post</b> request.", "text-align: center;");
