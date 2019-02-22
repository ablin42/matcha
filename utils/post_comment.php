<?php
session_start();
use \ablin42\database;
use \ablin42\autoloader;
require ("../class/autoloader.php");
require_once("functions.php");
autoloader::register();
$db = database::getInstance('camagru');

if (!empty($_POST['comment']) && !empty($_POST['id_img']))
{
        if (!check_length($_POST['comment'], 1, 255))
        {
            echo alert_bootstrap("warning", "Your <b>comment</b> has to be 1 character minimum and 255 characters maximum!", "text-align: center;");
            return ;
        }
        $db = database::getInstance('camagru');
        $attributesc = array();
        $attributesc['content'] = htmlspecialchars(trim($_POST['comment']));
        $attributesc['id_img'] = htmlspecialchars(trim($_POST['id_img']));
        $attributes2['username'] = $_SESSION['username'];

        $req = $db->prepare("SELECT * FROM `user` WHERE `username` = :username", $attributes2);
        if ($req)
        {
            foreach ($req as $item)
                $attributesc['id_user'] = $item->id;
        }
        else
            echo alert_bootstrap("danger", "<b>User</b> does not exist!", "text-align: center;");
        $req = $db->prepare("INSERT INTO `comment` (`id_img`, `id_user`, `content`, `date`) VALUES (:id_img, :id_user, :content, NOW())", $attributesc);
        mail_on_comment($db, $_POST['id_img']);
        echo alert_bootstrap("success", "Your <b>comment</b> has been <b>posted</b>!", "text-align: center;");
        header ('Refresh: 3;');
}
