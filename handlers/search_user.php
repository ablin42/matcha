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

require_once("../utils/pathinfo.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = secure_input($_SESSION['id']);
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
                $sortfield = 'distance';
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

        if (!$required_tags && $sortfield == "tagscore")
            $sortfield = 'tagscorenor';

        $attributes['id'] = $id;
        $req = $db->prepare("SELECT * FROM `user_location` WHERE `user_id` = :user_id", array("user_id" => secure_input($_SESSION['id'])));
        if ($req) {
            foreach ($req as $loc) {
                $attributes_loc['lat1'] = $loc->lat;
                $attributes_loc['lng1'] = $loc->lng;
            }
        } else
            $error_dist = 1;

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
        $basics = $db->prepare($query, $attributes);
        $matched_user = array();
        foreach ($basics as $basic) {
            $req = $db->prepare("SELECT * FROM `block` WHERE `id_blocked` = :user_id AND `id_blocker` = :id", array("user_id" => $basic->user_id, "id" => $id));
            if (!$req) {
                $rtagnb = 0;
                $info = array();
                $info['birthyear'] =  date("Y") - $basic->birth_year;
                $info['tagscorenor'] = 0;
                $info['tagscore'] = 0;
                $info['score'] = 0;
                array_push($info, $basic->user_id, $basic->username, $basic->gender, $basic->orientation);
                $attributes2 = array();
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

                $info['usertags'] = array();
                $req = $db->prepare("SELECT * FROM `user_tags` WHERE `user_id` = :user_id", $attributes2);
                if ($req) {
                    foreach ($req as $item) {
                        $info['usertags'][] = $item->tag;
                        $info['tagscorenor']++;
                    }
                }

                foreach ($info['usertags'] as $tag) {
                    foreach ($required_tags as $rtag) {;
                        if ($tag === $rtag)
                            $info['tagscore']++;
                    }
                }

                $info['mtags'] = array();
                foreach ($info['usertags'] as $key => $value) {
                    foreach ($required_tags as $rtag) {
                        if ($rtag === $value) {
                            unset($info['usertags'][$key]);
                            array_push($info['mtags'], $rtag);
                        }
                    }
                }

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

                switch (true)
                {
                    case ($info['distance'] <= 2):
                        $distscore = 150;
                        break;
                    case ($info['distance'] > 2 && $info['distance'] <= 4):
                        $distscore = 100;
                        break;
                    case ($info['distance'] > 4 && $info['distance'] <= 8):
                        $distscore = 50;
                        break;
                    case ($info['distance'] > 8 && $info['distance'] <= 10):
                        $distscore = 25;
                        break;
                    default:
                        $distscore = 0;
                }

                $info['totalscore'] = ($info['tagscore'] * 100) + ($info['score'] * 3) + $distscore;
                if ($info['score'] >= $minscore && $info['score'] <= $maxscore && $info['distance'] <= $mdistance && $info['profile_pic'] != "" && $basic->gender != "")
                    if (($required_tags && $info['tagscore'] >= 1 ) || !$required_tags)
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
        foreach ($arr as $key => $value) {
            foreach ($matched_user as $user) {
                if ($key == $user[0])
                    $sorted[] = $user;
            }
        }

        $i = 0;
        foreach ($sorted as $match) {
            if ($i % 2 === 0)
                echo "<div class='row'>";
            echo "<div class='result_block'>";
                    if ($match['profile_pic'])
                        echo "<div class='col-8 offset-2'>";
                    echo "<img class='profile_main' alt='profile_picture' src='".$match['profile_pic']."' />";
                    echo "<div class='text_block'>";
                    echo "<div class='user_info'>
                            <p class='user_name'><a href='/".$pathurl."/profile?u=".urlencode($match[1])."'>".$match[1]."</a></p>
                            <p class='age'>(".$match['birthyear'].")</p>
                            </br>
                            <div class='gender_distance'>
                            <p class='gender'>".$match[2].", ".$match[3]." ,</p>
                            <p class='distance'>".$match['distance']." KM away</p>
                            </div>
                            </div>";
                    echo "<p class='p_score'>Popularity score: <b class='score'>".$match['score']."</b></p>";
                    foreach ($match['mtags'] as $tag)
                    echo "<div class='matched_tag'><p>" . $tag . "</p></div>";
                     foreach ($match['usertags'] as $tag)
                    echo "<div class='profile_tag'><p>" . $tag . "</p></div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
            if ($i % 2 !== 0)
                echo "</div>";
            $i++;
        }
    } else {
        echo alert_bootstrap("danger", "You left a <b>required field</b> empty", "text-align: center;");
        return;
    }

} else
    echo alert_bootstrap("danger", "Not a <b>post</b> request.", "text-align: center;");