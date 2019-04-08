<?php
/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 4/05/19
 * Time: 9:22 PM
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
    $mdistance = 50;
    $data = json_decode(file_get_contents('php://input'));
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
                $sortfield = 'distance';
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
        if (!empty($data->{'location'}) && is_numeric($data->{'location'}))
            $mdistance = secure_input($data->{'location'});
        if (!empty($data->{'gender'}))
            $gender = secure_input($data->{'gender'});
        if (!empty($data->{'orientation'}))
            $orientation = secure_input($data->{'orientation'});

        $attributes['id'] = $id;
        $req = $db->prepare("SELECT * FROM `user_location` WHERE `user_id` = :user_id", array("user_id" => secure_input($_SESSION['id'])));
        if ($req) {
            foreach ($req as $loc) {
                $attributes_loc['lat1'] = $loc->lat;
                $attributes_loc['lng1'] = $loc->lng;
            }
        } else
            $error_dist = 1;
       // var_dump($gender, $orientation);
        if (!empty($gender) && $gender == "ALL" && !empty($orientation) && $orientation == "ALL")
            $query = "SELECT * FROM `user_info` RIGHT JOIN `user` ON user_info.user_id = user.id WHERE `birth_year` >= :bystart AND `birth_year` <= :byend AND `user_id` != :id";
        else if ((empty($orientation) || $orientation == "ALL") && !empty($gender) && $gender != "ALL") {
            $attributes['gender'] = $gender;
            $query = "SELECT * FROM `user_info` RIGHT JOIN `user` ON user_info.user_id = user.id WHERE `birth_year` >= :bystart AND `birth_year` <= :byend AND `user_id` != :id AND `gender` = :gender";
        } else if (!empty($orientation) && (empty($gender) || $gender == "ALL") && $orientation != "ALL") {
            $attributes['orientation'] = $orientation;
            $query = "SELECT * FROM `user_info` RIGHT JOIN `user` ON user_info.user_id = user.id WHERE `birth_year` >= :bystart AND `birth_year` <= :byend AND `user_id` != :id AND `orientation` = :orientation";
        }
        else if (!empty($gender) && $gender != "ALL" && !empty($orientation) && $orientation != "ALL"){
            $attributes['gender'] = $gender;
            $attributes['orientation'] = $orientation;
            $query = "SELECT * FROM `user_info` RIGHT JOIN `user` ON user_info.user_id = user.id WHERE `birth_year` >= :bystart AND `birth_year` <= :byend AND `user_id` != :id AND `orientation` = :orientation AND `gender` = :gender";
        }
        $attributes['bystart'] = $bystart;
        $attributes['byend'] = $byend;
        //var_dump($query, $attributes);
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
                if ($required_tags) {
                    foreach ($required_tags as $tag) {/////////////////////////////////
                        $attributes2['tag'] = $tag;
                        $req = $db->prepare("SELECT * FROM `user_tags` WHERE `user_id` = :user_id AND `tag` = :tag", $attributes2);
                        if ($req) {
                            $tags_arr[] = $req[0]->tag;
                            $info['tagscore']++;
                        }
                    }
                }
                else {
                    $req = $db->prepare("SELECT * FROM `user_tags` WHERE `user_id` = :user_id", $attributes2);
                    if ($req) {
                        foreach ($req as $tag) {
                            $tags_arr[] = $tag->tag;
                        }
                    }
                }
                $info['tags'] = $tags_arr;
                $req = $db->prepare("SELECT * FROM `user_location` WHERE `user_id` = :user_id", array("user_id" => $basic->user_id));
                if ($req) {
                    foreach ($req as $loc) {
                        $attributes_loc['lat2'] = $loc->lat;
                        $attributes_loc['lng2'] = $loc->lng;
                    }
                } else
                    $error_dist = 1;
                if ($error_dist != 1)
                    $info['distance'] = round(distance($attributes_loc['lat1'], $attributes_loc['lng1'], $attributes_loc['lat2'], $attributes_loc['lng2'], "K"));
                if ($info['score'] >= $minscore && $info['score'] <= $maxscore) {
                    foreach ($required_tags as $rtag) {
                        foreach ($tags_arr as $utag) {
                            if ($rtag == $utag)
                                $rtagnb++;
                        }
                    }
                    if ($rtagnb >= sizeof($required_tags) && $info['distance'] <= $mdistance)
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
        foreach ($arr as $key => $value) {
            foreach ($matched_user as $user) {
                if ($key == $user[0])
                    $sorted[] = $user;
            }
        }

        foreach ($sorted as $match) {
            echo "<div style='border: 1px solid red;'>";
            if ($match['profile_pic'])
                echo "<img class='profile_main' alt='profile_picture' src='" . $match['profile_pic'] . "' />";
            echo "<p><a href='/Matcha/profile?u=" . $match[1] . "'>" . $match[1] . "</a> (" . $match['birthyear'] . "), <i>" . $match[2] . ", " . $match[3] . "</i> - " . $match['distance'] . " KM away</p>";
            echo "<p>Popularity score: <b>" . $match['score'] . "</b></p>";
            echo "<p>Interested in: </p>";
            foreach ($match['tags'] as $tag)
                echo "<div class='profile_tag'><p>" . $tag . "</p></div>";
            echo "</div><br />";
        }
    } else {
        echo alert_bootstrap("danger", "You left a <b>required field</b> empty", "text-align: center;");
        return;
    }

} else
    echo alert_bootstrap("danger", "Not a <b>post</b> request.", "text-align: center;");