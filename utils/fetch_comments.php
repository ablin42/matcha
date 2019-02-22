<?php
use \ablin42\database;

$db = database::getInstance('camagru');

$req = $db->prepare("SELECT comment.id AS id_com, content, username FROM `comment` LEFT JOIN `user` ON comment.id_user = user.id WHERE comment.id_img = :id ORDER BY `date` DESC", $attributes);
foreach($req as $item)
{
    echo "<div class=\"comment\" id=\"{$item->id_com}\">";
    echo "<b class='com-username'>{$item->username}</b>";
    echo "<p class='com-content'>{$item->content}</p>";
    echo "</div>";
}