<?php
/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 3/14/19
 * Time: 8:21 PM
 */
session_start();
use \ablin42\database;
use \ablin42\autoloader;
require ("../class/autoloader.php");
require_once("../utils/functions.php");
autoloader::register();
$db = database::getInstance('matcha');

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_FILES['picture']) && !empty($_POST['picture-id']) && is_numeric($_POST['picture-id'])) {
    $photo = "photo" . secure_input($_POST['picture-id']);
    $max_file_size = 2000000;
    $attributes = array();
    $attributes['user_id'] = secure_input($_SESSION['id']);
    $req = $db->prepare("SELECT * FROM `user` WHERE `id` = :user_id", $attributes);
    if (!$req) {
        echo alert_bootstrap("danger", "Error: User not found. Please try again. If the error persist try disconnecting and reconnecting", "text-align: center;");
        return;
    }
    if($_FILES['picture']['error'] > 0) {
        echo alert_bootstrap("danger", "An <b>error</b> occured during the upload! Please, try again.", "text-align: center;");
        return ;
    }

    if($_FILES['picture']['size'] > $max_file_size) {
        echo alert_bootstrap("danger", "<b>Error:</b> The file you select is too big (> 2MB).", "text-align: center;");
        return ;
    }

    $valid_extensions = array('jpg', 'jpeg', 'png');
    $extension_upload = strtolower(substr(strrchr($_FILES['picture']['name'],'.'),1));
    if (!in_array($extension_upload, $valid_extensions)) {
        echo alert_bootstrap("danger", "<b>Error:</b> File extension is not valid! <b>(Extension authorized: jpg, jpeg, gif, png)</b>", "text-align: center;");
        return ;
    }

    $image_size = getimagesize($_FILES['picture']['tmp_name']);
    if ($image_size[0] != 0 && $image_size[1] != 0 && $image_size[0] < $image_size[1]) {
        echo alert_bootstrap("danger", "<b>Error:</b> File dimensions aren't valid! <b>(height has to be smaller than width!)</b>", "text-align: center;");
        return ;
    }

    $req = $db->prepare("SELECT * FROM `user_photo` WHERE `user_id` = :user_id", $attributes);
    $filename = gen_token(40);
    $attributes['path'] = "photos/{$filename}.{$extension_upload}";
    move_uploaded_file($_FILES['picture']['tmp_name'], $attributes['path']);

    if ($req)
        $req = $db->prepare("UPDATE `user_photo` SET $photo = :path WHERE `user_id` = :user_id", $attributes);
    else
    {
        var_dump($attributes, $photo);
        $req = $db->prepare("INSERT INTO `user_photo` (`user_id`, $photo) VALUE (:user_id, :path)", $attributes);
        echo "XD";
    }
    echo alert_bootstrap("success", "<b>Your photo has been <b>successfully updated</b>!", "text-align: center;");
}
else
    alert_bootstrap("danger" , "Not a <b>post</b> request or <b>wrong data</b> sent.", "text-align: center;");