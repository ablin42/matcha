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
require ("../class/autoloader.php");
require_once("../utils/functions.php");
autoloader::register();
$db = database::getInstance('matcha');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'));
    if (!empty($data->{'firstname'}) && !empty($data->{'lastname'}) && !empty($data->{'birth_year'}) && !empty($data->{'username'}) && !empty($data->{'email'}) && !empty($data->{'password'}) && !empty($data->{'password2'})) {
        $firstname = secure_input($data->{'firstname'});
        $lastname = secure_input($data->{'lastname'});
        $birth_year = (int)secure_input($data->{'birth_year'});
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
            if (!check_length($firstname, 2, 16)) {
                echo alert_bootstrap("warning", "Your <b>firstname</b> has to be 2 characters minimum and 16 characters maximum!", "text-align: center;");
                return ;
            }
            if (!check_length($lastname, 2, 16)) {
                echo alert_bootstrap("warning", "Your <b>lastname</b> has to be 2 characters minimum and 16 characters maximum!", "text-align: center;");
                return ;
            }
            if ($birth_year < 1940 || $birth_year > 2001) {
                echo alert_bootstrap("warning", "Your <b>birth year</b> must be in the range <b>1940-2001</b>", "text-align: center;");
                return ;
            }
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

            $attributes_info = array();
            $attributes_info['user_id'] = $user_id;
            $attributes_info['firstname'] = $firstname;
            $attributes_info['lastname'] = $lastname;
            $attributes_info['birth'] = $birth_year;
            $db->prepare("INSERT INTO `user_info` (`user_id`, `firstname`, `lastname`, `birth_year`) VALUES (:user_id, :firstname, :lastname, :birth)", $attributes_info);

            $ipaddress = get_client_ip();
            $PublicIP = "62.210.34.50"; //get_client_ip();
            //$json = file_get_contents("http://ipinfo.io/$PublicIP/geo");
            $json = file_get_contents("http://api.ipstack.com/62.210.34.50?access_key=39cbaf113fdf77368d7b438232d1428c");
            $data = json_decode($json, true);
            $lat = $data['latitude'];
            $lng = $data['longitude'];
            $req = $db->prepare("INSERT INTO `user_location` (`user_id`, `lat`, `lng`) VALUES (:user_id, :lat, :lng)",
                                array("user_id" => $user_id, "lat" => $lat, "lng" => $lng));

            $subject = "Confirm your account at Matcha";
            $message = "In order to confirm your account, please click this link: \n\nhttp://localhost:8080/Matcha/utils/confirm_account.php?id=$user_id&token=$token";
            mail($email, $subject, $message);
            echo alert_bootstrap("success", "<b>Your account has been successfully created!</b> Please <b>confirm your email</b> by clicking the link we sent at your e-mail address", "text-align: center;");
        }
        else
            echo alert_bootstrap("danger", "<b>The passwords you entered didn't match.</b>", "text-align: center;");
    }
    else
        echo alert_bootstrap("warning" , "A <b>field</b> is empty", "text-align: center;");
}
else
    echo alert_bootstrap("danger" , "Not a <b>post</b> request.", "text-align: center;");
