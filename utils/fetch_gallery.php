<?php
use \ablin42\database;

$db = database::getInstance('camagru');
$req = $db->query("SELECT * FROM `image` ORDER BY `date` DESC LIMIT {$startLimit}, {$perPage}");

$i = 0;
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
if (isset($_SESSION['id']))
{
    $id = $_SESSION['id'];
    $req = $db->prepare("SELECT `infinite_scroll` FROM `user` WHERE `id` = :id", array("id" => $id));
    if ($req)
    {
        foreach ($req as $item)
            if ($item->infinite_scroll == 0) {
                echo '<div style="width:100%"><nav class="navbar-dark">';
                echo '<ul class="pagination justify-content-center">';
                for ($i = 1; $i <= $nbPage; $i++) {
                    if ($i == $cPage)
                        echo "<li class=\"page-item active\"><a class=\"page-link\" href=\"?p={$i}\">{$i}</a></li>";
                    else
                        echo "<li class=\"page-item\"><a class=\"page-link\" href=\"?p={$i}\">{$i}</a></li>";
                }
                echo '</ul>';
                echo '</nav></div>';
            }
    }
}