<?php
/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 3/5/19
 * Time: 8:44 PM
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
    if (!empty($data->{'username'}) && !empty($data->{'password'})) {
        $attributes_h['username'] = htmlspecialchars(trim($data->{'username'}));
        $pwd = hash('whirlpool', $data->{'password'});
        $req = $db->prepare("SELECT * FROM `user` WHERE `username` = :username", $attributes_h);
        if ($req) {
            foreach ($req as $elem) {
                if ($elem->confirmed_token !== NULL) {
                    if ($elem->password === $pwd) {
                        $_SESSION['username'] = $elem->username;
                        $_SESSION['logged'] = 1;//
                        $_SESSION['id'] = $elem->id;//
                        echo alert_bootstrap("success", "You've been <b>logged in!</b>", "text-align: center;");
                        header('Refresh: 1; /Matcha/Account');
                    } else
                        echo alert_bootstrap("warning", "Incorrect password!", "text-align: center;");
                } else {
                    $subject = "Confirm your account at Matcha";
                    $message = "In order to confirm your account, please click this link: \n\nhttp://localhost:8080/Matcha/utils/confirm_account.php?id=$user_id&token=$token";
                    mail($elem->email, $subject, $message);
                    echo alert_bootstrap("info", "You did not <b>confirm your account</b> yet, we just sent you another <b>e-mail</b> to confirm your account.", "text-align: center;");
                }

            }
        } else
            echo alert_bootstrap("warning", "This user does not exist!", "text-align: center;");
    }
}