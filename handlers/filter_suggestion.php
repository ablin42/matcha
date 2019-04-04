<?php
/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 4/03/19
 * Time: 6:32 PM
 */

session_start();
use \ablin42\autoloader;
use \ablin42\database;
require("../class/autoloader.php");
require("../utils/functions.php");
autoloader::register();
$db = database::getInstance('matcha');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = secure_input($_SESSION['id']);
    $sortfield = 'totalscore';
    $sorttype = "des";
    $bystart = 1940;
    $byend = 2001;
    $minscore = 0;
    $maxscore = 250;
    $required_tags = array();
    $data = json_decode(file_get_contents('php://input'));
    //echo json_encode($data);
    if (!empty($data->{'sort'}) && !empty($data->{'order'})) {
        $sort = secure_input($data->{'sort'});
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
        if (!empty($data->{'order'}))
            if ($data->{'order'} == "asc")
                $sorttype = "asc";
        if (!empty($data->{'bystart'}) && is_numeric($data->{'bystart'}))
            $bystart = secure_input($data->{'bystart'});
        if (!empty($data->{'byend'}) && is_numeric($data->{'byend'}))
            $byend = secure_input($data->{'byend'});
        if ($bystart > $byend)
            swap($bystart, $byend);
        if (!empty($data->{'pstart'}) && is_numeric($data->{'pstart'}))
            $minscore = secure_input($data->{'pstart'});
        if (!empty($data->{'pend'}) && is_numeric($data->{'pend'}))
            $maxscore = secure_input($data->{'pend'});
        if ($minscore > $maxscore)
            swap($minscore, $maxscore);
        if (!empty($data->{'tags'}))
            $required_tags = $data->{'tags'};

        $attributes['id'] = $id;
        $req = $db->prepare("SELECT * FROM `user_info` WHERE `user_id` = :id", $attributes);
        if ($req) {
            foreach ($req as $item) {
                $gender = $item->gender;
                $orientation = $item->orientation;
                $bio = $item->bio;
                $firstname = $item->firstname;
                $lastname = $item->lastname;
            }
        }

        $req = $db->prepare("SELECT SUM(`type`) as sum, COUNT(*) as total FROM `vote` WHERE `id_voted` = :id", $attributes);
        if ($req)
            $score = $req[0]->sum * $req[0]->total;
        else
            $score = 0;

        $req = $db->prepare("SELECT `tag` FROM `user_tags` WHERE `user_id` = :id", $attributes);
        if ($req) {
            $tags = array();
            foreach ($req as $item)
                array_push($tags, $item->tag);
        }

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
                $rtagnb = 0;
                $info = array();
                $info['birthyear'] = $basic->birth_year;
                $info['tagscore'] = 0;
                array_push($info, $basic->user_id, $basic->username, $basic->gender, $basic->orientation);
                $attributes2['user_id'] = $basic->user_id;
                $req = $db->prepare("SELECT * FROM `user_photo` WHERE `user_id` = :user_id", array("user_id" => $basic->user_id));
                if ($req)
                    foreach ($req as $item)
                        $info['profile_pic'] = $item->photo1;
                else
                    $info['profile_pic'] = null;
                $req = $db->prepare("SELECT SUM(`type`) as sum, COUNT(*) as total FROM `vote` WHERE `id_voted` = :voted", array("voted" => $basic->user_id));
                if ($req)
                    $info['score'] = $req[0]->sum * $req[0]->total;
                else
                    $info['score'] = 0;
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
                $oriscore = 100;
                if ($basic->orientation === "Bisexual")
                    $oriscore = 75;
                $info['totalscore'] = $oriscore + ($info['tagscore'] * 50) + ($info['score'] * 5); //+ geo score+ maybe orientation score (orientation/geoscore/tagscore/pop)
                if ($info['score'] >= $minscore && $info['score'] <= $maxscore) {
                    foreach ($required_tags as $rtag) {
                        foreach ($tags_arr as $utag) {
                            if ($rtag == $utag)
                                $rtagnb++;
                        }
                    }
                    if ($rtagnb >= sizeof($required_tags))
                        array_push($matched_user, $info);
                }
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

        foreach ($sorted as $match)
        {
            echo "<div style='border: 1px solid red;'>";
            if ($match['profile_pic'])
                echo "<img class='profile_main' alt='profile_picture' src='".$match['profile_pic']."' />";
            echo "<p><a href='/Matcha/profile?u=".$match[1]."'>".$match[1]."</a>, <i>".$match[2].", ".$match[3]."</i></p>";
            echo "<p>Popularity score: <b>".$match['score']."</b></p>";
            echo "<p>You're both interested in: </p>";
            foreach ($match['tags'] as $tag)
                echo "<div class='profile_tag'><p>".$tag."</p></div>";
            echo "</div><br />";
        }
    }
    else {
        echo alert_bootstrap("danger", "You left a <b>required field</b> empty", "text-align: center;");
        return;
    }

} else
    echo alert_bootstrap("danger", "Not a <b>post</b> request.", "text-align: center;");