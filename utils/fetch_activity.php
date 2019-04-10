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

    $likes = $db->prepare("SELECT * FROM `vote` RIGHT JOIN `user` ON vote.id_voter = user.id WHERE `id_voted` = :voted AND `type` = 1", array("voted" => $id));

    $req= $db->prepare("SELECT * FROM `vote` RIGHT JOIN `user` ON vote.id_voter = user.id WHERE `id_voted` = :voted", array("voted" => $id));
    if ($req)
        foreach ($req as $item)
        {
            $attributes['voter'] = $id;
            $attributes['voted'] = $item->id_voter;
            $matching = $db->prepare("SELECT * FROM `vote` WHERE `id_voter` =:voter AND `id_voted` = :voted", $attributes);
            if ($matching) {
                $matching['username'] = $item->username;
                $matched[] = $matching;
            }
        }
    $req = $db->prepare("SELECT SUM(`type`) as sum, COUNT(*) as total FROM `vote` WHERE `id_voted` = :voted", array("voted" => $id));
    if ($req) {
        $sum = $req[0]->sum;
        $nbvote = $req[0]->total;
        $score = $sum * $nbvote;
    }
    else
        $score = 0;
}


