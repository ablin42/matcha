<?php
session_start();
use \ablin42\autoloader;
use \ablin42\database;

require ("../class/autoloader.php");
require ("functions.php");
autoloader::register();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['id']) && !empty($_POST['u']))
{
    $db = database::getInstance('camagru');
    $id = secure_input($_POST['id']);
    $u = secure_input($_POST['u']);
    $req = $db->prepare("SELECT * FROM `image` WHERE `id` = :id", array("id" => $id));
    if ($req)
    {
        if (!has_liked($db, $id, $u))
        {
            $db->prepare("INSERT INTO `vote` (`id_img`, `id_user`) VALUES (:id_img, :id_user)", array("id_img" => $id, "id_user" => $u));
            $req = $db->prepare("SELECT count(id) as count FROM `vote` WHERE `id_img` = :id_img", array("id_img" => $id));
            $like = 0;
            foreach ($req as $item)
            {
                $like = $item->count;
                break;
            }
            $db->prepare("UPDATE `image` SET `nb_like` = :like WHERE `id` = :id_img", array("like" => $like, "id_img" => $id));
        }
        else
        {
            $db->prepare("DELETE FROM `vote` WHERE `id_img` = :id_img AND `id_user` = :id_user", array("id_img" => $id, "id_user" => $u));
            $req = $db->prepare("SELECT count(id) as count FROM `vote` WHERE `id_img` = :id_img", array("id_img" => $id));
            $like = 0;
            foreach ($req as $item)
            {
                $like = $item->count;
                break;
            }
            $db->prepare("UPDATE `image` SET `nb_like` = :like WHERE `id` = :id_img", array("like" => $like, "id_img" => $id));
        }
    }
}?>
<script>
    var $nb_like = document.getElementById("nb_like");
    $nb_like.innerText = <?= $like ?>;
</script>