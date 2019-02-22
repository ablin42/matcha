<?php
session_start();
use \ablin42\database;
use \ablin42\autoloader;
require ("../class/autoloader.php");
require_once("functions.php");
autoloader::register();
$db = database::getInstance('camagru');

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['img_url']) && !empty($_SESSION['id']) && !empty($_POST['img_name']))
{
    $img_url = "../{$_POST['img_url']}";
    $img_name = secure_input($_POST['img_name']);
    $img_url = secure_input($img_url);
    $user_id = secure_input($_SESSION['id']);
    if (!check_length($img_name, 1, 64))
    {
        echo alert_bootstrap("warning", "Your <b>title</b> has to be 1 character minimum and 64 characters maximum!", "text-align: center;");
        return ;
    }

    $db = database::getInstance('camagru');
    $req = $db->query( "SELECT MAX(id) as last_id FROM `image`");
    foreach($req as $item)
        $id_img = $item->last_id + 1;
    $path = "../images/{$id_img}.png";

    $photo = imagecreatefrompng($img_url);
    imagepng($photo, $path);
    imagedestroy($photo);
    //unlink($img_url);

    $path = "/Camagru/images/{$id_img}.png";
    $attributes['id_user'] = htmlspecialchars(trim($user_id));
    $attributes['path'] = $path;
    $attributes['name'] =  strtolower(htmlspecialchars(trim($img_name)));
    $req = $db->prepare("INSERT INTO `image` (`id_user`, `path`, `name`, `date`) VALUES (:id_user, :path, :name, NOW())", $attributes);
    echo alert_bootstrap("success", "<b>Congratulations!</b> Your picture has been posted!", "text-align: center;");
}