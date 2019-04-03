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
    $sortfield = 'totalscore';
    $sorttype = "des";
    $bystart = 1940;
    $byend = 2001;
    $minscore = 0;
    $maxscore = 250;
    $data = json_decode(file_get_contents('php://input'));
    echo json_encode($data);
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
        var_dump($bystart, $byend, $minscore, $maxscore);
    }
    else
        echo alert_bootstrap("danger", "You left a <b>required field</b> empty", "text-align: center;");
} else
    echo alert_bootstrap("danger", "Not a <b>post</b> request.", "text-align: center;");