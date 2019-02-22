<?php
use \ablin42\database;
use \ablin42\autoloader;
require ("../class/autoloader.php");
require ("functions.php");
autoloader::register();

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['id_img']) && !empty($_POST['lastid']))
{
    $arr['lastid'] = (int) secure_input($_POST['lastid']);
    $arr['id_img'] = (int) secure_input($_POST['id_img']);

    $db = database::getInstance('camagru');
    $req = $db->prepare("SELECT comment.id AS id_com, content, username FROM `comment` LEFT JOIN `user` ON comment.id_user = user.id WHERE comment.id_img = :id_img AND comment.id > :lastid ORDER BY `date` DESC LIMIT 10", $arr);
    if ($req)
        foreach($req as $item)
        {
            echo "<div class='comment' id=\"{$item->id_com}\">";
            echo "<b class='com-username'>{$item->username}</b>";
            echo "<p class='com-content'>{$item->content}</p>";
            echo "</div>";
        }
}
else
    return ;