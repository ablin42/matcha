<?php
/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 3/28/19
 * Time: 5:38 PM
 */
use \ablin42\database;
$db = database::getInstance('matcha');

if (!empty($_SESSION['id'])) {
    $sortfield = 'totalscore';
    $sorttype = "des";
    $bystart = 1940;
    $byend = 2001;
    $minscore = 0;
    $maxscore = 1000;
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        if (!empty($_GET['pstart']) && is_numeric($_GET['pstart']))
            $minscore = secure_input($_GET['pstart']);
        if (!empty($_GET['pend']) && is_numeric($_GET['pend']))
            $maxscore = secure_input($_GET['pend']);
        if (!empty($_GET['type']))
            if ($_GET['type'] == "asc")
                $sorttype = "asc";
        if (!empty($_GET['bystart']) && !empty($_GET['byend']) && is_numeric($_GET['bystart']) && is_numeric($_GET['byend']))
        {
            //check nbr range
            $bystart = secure_input($_GET['bystart']);
            $byend = secure_input($_GET['byend']);
        }
        if (!empty($_GET['sort'])) {
            $sort = secure_input($_GET['sort']);
            switch ($sort) {
                case "Standard":
                    $sortfield = 'totalscore';
                    break;
                case "Age":
                    $sortfield = 'birthyear';
                    break;
                case "Location":
                    $sortfield = 'location';
                    break;
                case "Popularity":
                    $sortfield = 'score';
                    break;
                case "Tags":
                    $sortfield = 'tagscore';
                    break;
                default:
                    $sortfield = 'totalscore';
            }
        }
    }
    $id = secure_input($_SESSION['id']);
    $attributes['id'] = $id;

    $req = $db->prepare("SELECT `tag` FROM `user_tags` WHERE `user_id` = :user_id", array("user_id" => $id));
    if ($req) {
        $tags = array();
        foreach ($req as $item)
            array_push($tags, $item->tag);
    }

    $req = $db->prepare("SELECT * FROM `user_location` WHERE `user_id` = :user_id", array("user_id" => $id));
    if ($req) {
        foreach ($req as $loc)
        {
            $attributes_loc['lat1'] = $loc->lat;
            $attributes_loc['lng1'] = $loc->lng;
        }
    }
    else
        $error_dist = 1;

    $query = "SELECT * FROM `user_info` RIGHT JOIN `user` ON user_info.user_id = user.id WHERE `gender` = :gender
     AND (`orientation` = :orientation OR `orientation` = 'Bisexual') AND `user_id` != :id AND `birth_year` >= :bystart AND `birth_year` <= :byend";

    if ($gender === "Male" && $orientation === "Heterosexual") //female bi ou hetero
    {
        $attributes['gender'] = "Female";
        $attributes['orientation'] = "Heterosexual";
    } else if ($gender === "Male" && $orientation === "Homosexual") //male bi ou homo
    {
        $attributes['gender'] = "Male";
        $attributes['orientation'] = "Homosexual";
    } else if ($gender === "Female" && $orientation === "Heterosexual") //male bi ou hetero
    {
        $attributes['gender'] = "Male";
        $attributes['orientation'] = "Heterosexual";
    } else if ($gender === "Female" && $orientation === "Homosexual") //female bi ou hetero
    {
        $attributes['gender'] = "Female";
        $attributes['orientation'] = "Homosexual";
    } else if ($gender === "Male" && $orientation === "Bisexual") //homosexual male / heterosexual female / bi female / bi male
    {
        $query = "SELECT * FROM `user_info` 
                  RIGHT JOIN `user` ON user_info.user_id = user.id 
                  WHERE (`gender` = 'Male' AND (`orientation` = 'Bisexual' OR `orientation` = 'Homosexual') 
                  AND `user_id` != :id AND `birth_year` >= :bystart AND `birth_year` <= :byend)
                  OR (`gender` = 'Female' AND (`orientation` = 'Bisexual' OR `orientation` = 'Heterosexual') 
                  AND `user_id` != :id AND `birth_year` >= :bystart AND `birth_year` <= :byend)";
    } else if ($gender === "Female" && $orientation === "Bisexual") //homosexual female / heterosexual male / bi male / bi female
    {
        $query = "SELECT * FROM `user_info`
                  RIGHT JOIN `user` ON user_info.user_id = user.id 
                  WHERE (`gender` = 'Female' AND (`orientation` = 'Bisexual' OR `orientation` = 'Homosexual') 
                  AND `user_id` != :id AND `birth_year` >= :bystart AND `birth_year` <= :byend)
                  OR (`gender` = 'Male' AND (`orientation` = 'Bisexual' OR `orientation` = 'Heterosexual') 
                  AND `user_id` != :id AND `birth_year` >= :bystart AND `birth_year` <= :byend) ";
    }

    $attributes['bystart'] = $bystart;
    $attributes['byend'] = $byend;
    $basics = $db->prepare($query, $attributes);
    $matched_user = array();
    foreach ($basics as $basic) {
        $req = $db->prepare("SELECT * FROM `block` WHERE `id_blocked` = :user_id AND `id_blocker` = :id", array("user_id" => $basic->user_id, "id" => $id));
        if (!$req) {
            $info = array();
            $info['birthyear'] = $basic->birth_year;
            $info['tagscore'] = 0;
            $info['score'] = 0;
            array_push($info, $basic->user_id, $basic->username, $basic->gender, $basic->orientation);
            $attributes2['user_id'] = $basic->user_id;
            $req = $db->prepare("SELECT * FROM `user_photo` WHERE `user_id` = :user_id", array("user_id" => $basic->user_id));
            if ($req)
                foreach ($req as $item)
                    $info['profile_pic'] = $item->photo1;
            else
                $info['profile_pic'] = null;
            $reqvote = $db->prepare("SELECT SUM(`type`) as sum, COUNT(*) as total FROM `vote` WHERE `id_voted` = :voted", array("voted" => $basic->user_id), true);
            if ($reqvote)
                $info['score'] = $reqvote->sum * $reqvote->total;

            $req = $db->prepare("SELECT COUNT(*) AS nbvisit FROM `visit` WHERE `id_visited` = :user_id", array("user_id" => $basic->user_id), true);
            if ($req)
                $info['score'] += ($req->nbvisit * $reqvote->total);

            $tags_arr = array();
            foreach ($tags as $tag) {
                $attributes2['tag'] = $tag;
                $req = $db->prepare("SELECT * FROM `user_tags` WHERE `user_id` = :user_id AND `tag` = :tag", $attributes2);
                if ($req) {
                    $tags_arr[] = $req[0]->tag;
                    $info['tagscore']++;
                }
                $info['tags'] = $tags_arr;
            }
            $req = $db->prepare("SELECT * FROM `user_location` WHERE `user_id` = :user_id", array("user_id" => $basic->user_id));
            if ($req) {
                foreach ($req as $loc)
                {
                    $attributes_loc['lat2'] = $loc->lat;
                    $attributes_loc['lng2'] = $loc->lng;
                }
            }
            else
                $error_dist = 1;
            if ($error_dist != 1)
                $info['distance'] = round(distance($attributes_loc['lat1'], $attributes_loc['lng1'], $attributes_loc['lat2'], $attributes_loc['lng2'], "K"));

            $info['totalscore'] =  ($info['tagscore'] * 50) + ($info['score'] * 5) - ($info['distance'] * 10); //+ geo score+ maybe orientation score (orientation/geoscore/tagscore/pop)
            if ($info['score'] >= $minscore && $info['score'] <= $maxscore)
                array_push($matched_user, $info);
        }
    }

    $arr = array();
    foreach ($matched_user as $user)
        $arr[$user[0]] = $user[$sortfield];
    if ($sorttype === "des")
        arsort($arr);
    else
        asort($arr);

    $sorted = array();
    foreach ($arr as $key => $value)
    {
        foreach ($matched_user as $user)
        {
            if ($key == $user[0])
                $sorted[] = $user;
        }
    }
}