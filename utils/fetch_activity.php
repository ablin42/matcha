<?php
/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 3/27/19
 * Time: 6:21 PM
 */
use \ablin42\database;
$db = database::getInstance('matcha');
if ($_SESSION['id'])
{
    $id = secure_input($_SESSION['id']);
    $visits = $db->prepare("SELECT * FROM `visit` RIGHT JOIN `user` ON visit.id_visitor = user.id WHERE `id_visited` = :user_id", array("user_id" => $id));
}



