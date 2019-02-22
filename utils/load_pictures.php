<?php
use \ablin42\database;
use \ablin42\autoloader;
require ("../class/autoloader.php");
require ("functions.php");
autoloader::register();

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['lastid']))
{
    $arr['lastid'] = (int) secure_input($_POST['lastid']);

    $db = database::getInstance('camagru');
    $req = $db->prepare("SELECT `id_user` FROM `image` WHERE `id` = :lastid", $arr);
    if ($req)
    {
        foreach ($req as $item)
            $arr['id_user'] = $item->id_user;
    }
    else
        return ;

    $req = $db->prepare("SELECT * FROM `image` WHERE `id_user` = :id_user AND `id` > :lastid ORDER BY `date` DESC", $arr);
    if ($req)
        foreach($req as $item)
        {
            echo "<div class='your-img' style='text-align: center;' id=\"img_{$item->id}\">";
            echo "<h6>$item->name</h6>";
            echo "<img class='img-mini' width='100%' src=\"$item->path\" alt=\"$item->name\" />";
            echo "<a onclick=\"return deleteImg({$item->id})\" href=\"\"><i class=\"fas fa-trash rmv-img\"></i></a>";
            echo "</div>";
        }
}
else
    return ;