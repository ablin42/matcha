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
    $mdistance = 50;
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

        $req = $db->prepare("SELECT `tag` FROM `user_tags` WHERE `user_id` = :id", $attributes);
        if ($req) {
            $tags = array();
            foreach ($req as $item)
                array_push($tags, $item->tag);
        }

        $req = $db->prepare("SELECT * FROM `user_location` WHERE `user_id` = :user_id", array("user_id" => secure_input($_SESSION['id'])));
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
                $rtagnb = 0;
                $info = array();
                $info['birthyear'] = 2019 - (int)$basic->birth_year;
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
                $info['distcore'] = $distscore;
                $info['totalscore'] = ($info['tagscore'] * 100) + ($info['score'] * 3) + $distscore; //+ geo score+ maybe orientation score (orientation/geoscore/tagscore/pop)
                if ($info['score'] >= $minscore && $info['score'] <= $maxscore && $info['distance'] <= $mdistance && $info['tagscore'] !== 0) {
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
          $age = 2019 - (int)$match['birthyear'];
          echo "<div class='result_block'>";
          if ($match['profile_pic'])
          echo "<img class='profile_main' alt='profile_picture' src='".$match['profile_pic']."' />";
          echo "<div class='text_block'>";
          echo "<div class='user_info'>
                  <p class='user_name'><a href='/Matcha/profile?u=".$match[1]."'>".$match[1]."</a></p>
                  <p class='age'>('$age')</p>
                  </br>
                  <div class='gender_distance'>
                  <p class='gender'>".$match[2].", ".$match[3]." ,</p>
                  <p class='distance'>".$match['distance']." KM away</p>
                  </div>
                  </div>";
          echo "<p class='p_score'>Popularity score: <b class='score'>".$match['score']."</b></p>";
          // echo "<p class='p_score'>You're both interested in: </p>";
          foreach ($match['tags'] as $tag)
              echo "<div class='profile_tag'><p>".$tag."</p></div>";
          echo "</div>";
          echo "</div>";
        }
    }
    else {
        echo alert_bootstrap("danger", "You left a <b>required field</b> empty", "text-align: center;");
        return;
    }

} else
    echo alert_bootstrap("danger", "Not a <b>post</b> request.", "text-align: center;");