<?php
use \ablin42\database;

$db = database::getInstance('camagru');

$id = secure_input($_SESSION['id']);
$req = $db->prepare("SELECT * FROM `image` WHERE `id_user` = :id_user ORDER BY `date` DESC", array("id_user" => $id));
foreach($req as $item)
{
  echo "<div class='your-img' style='text-align: center;' id=\"img_{$item->id}\">";
    echo "<h6>$item->name</h6>";
    echo "<img class='img-mini' width='100%' src=\"$item->path\" alt=\"$item->name\" />";
    echo "<a onclick=\"return deleteImg({$item->id})\" href=\"\"><i class=\"fas fa-trash rmv-img\"></i></a>";
  echo "</div>";
}