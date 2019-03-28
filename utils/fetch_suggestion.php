<?php
/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 3/28/19
 * Time: 5:38 PM
 */
use \ablin42\database;
$db = database::getInstance('matcha');

/*
       $gender //user_info
       $orientation  //user_info
       $tags //user_tags
       $score //vote
    */


if (!empty($_SESSION['id'])) {
    $id = secure_input($_SESSION['id']);
    $attributes['id'] = $id;

    $req = $db->prepare("SELECT SUM(`type`) as sum, COUNT(*) as total FROM `vote` WHERE `id_voted` = :voted", array("voted" => $id));
    if ($req) {
        $sum = $req[0]->sum;
        $nbvote = $req[0]->total;
        $score = $sum * $nbvote;
    }

    $req = $db->prepare("SELECT `tag` FROM `user_tags` WHERE `user_id` = :user_id", array("user_id" => secure_input($_SESSION['id'])));
    if ($req) {
        $tags = array();
        foreach ($req as $item)
            array_push($tags, $item->tag);
    }

    if ($gender === "Male" && $orientation === "Heterosexual")
    {
        $attributes['gender'] = "Female"; //female bi ou hetero
        $attributes['orientation'] = "Heterosexual";
    }/*
    else if ($gender === "Male" && $orientation === "Homosexual")
    {
        //male bi ou hetero
    }
    else if ($gender === "Female" && $orientation === "Heterosexual")
    {
        //male bi ou hetero
    }
    else if ($gender === "Female" && $orientation === "Homosexual")
    {
        //female bi ou hetero
    }
    else if ($gender === "Male" && $orientation === "Bisexual")
    {
        //homosexual male / heterosexual female
    }
    else if ($gender === "Female" && $orientation === "Bisexual")
    {
        //homosexual female / heterosexual male
    }*/

    $attributes['gender'] = "Female";
    $attributes['orientation'] = "Heterosexual";
    $basics = $db->prepare("SELECT * FROM `user_info` WHERE `gender` = :gender AND (`orientation` = :orientation OR `orientation` = 'Bisexual') AND `user_id` != :id", $attributes);

    foreach ($basics as $basic) {
        var_dump($basic);
        echo "<br /><br />";
        $attributes2['user_id'] = $basic->user_id;
        foreach ($tags as $tag)
        {
            $attributes2['tag'] = $tag;
            $req = $db->prepare("SELECT * FROM `user_tags` WHERE `user_id` = :user_id AND `tag` = :tag", $attributes2);
            if ($req)
                echo $req[0]->tag;/////////////////////push les tags dans un tableau pour chaque user + tag score en fonction du nb de tag qui match
        }
    }
}
