<?php
use \ablin42\database;
use \ablin42\autoloader;
require ("../class/autoloader.php");
require ("functions.php");
autoloader::register();

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['lastid']))
{
    $lastid = (int) secure_input($_POST['lastid']);

    $db = database::getInstance('camagru');
    $req = $db->query("SELECT * FROM `image` WHERE `id` < {$lastid} ORDER BY `date` DESC LIMIT 0, 6");
    $i = 0;
    if ($req)
        foreach($req as $item)
        {
            if ($i % 2 === 0)
                echo '<div class="row justify-content-center">';
            echo '<div class="img-container col-5';
            if ($i % 2 === 0)
                echo ' offset-1">';
            else
                echo ' col-sm-offset-right-1">';
            echo "<div class='gallery-img-wrapper' id=\"{$item->id}\">
              <a href=\"/Camagru/image?id={$item->id}\">
              <img alt=\"{$item->name}\" class=\"gallery-img col-12\" src=\"{$item->path}\">
              <div class='overlay'><div class=\"title-on-img\">{$item->name}</div></div></a></div>";

            echo '</div>';
            if ($i % 2 !== 0)
                echo '</div>';
            $i++;
        }
}
else
    return ;