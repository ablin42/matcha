<?php

function is_notified($db, $type, $id_notifier, $user_id){
    $attributes['type'] = secure_input($type);
    $attributes['id_notifier'] = secure_input($id_notifier);
    $attributes['user_id'] = secure_input($user_id);
    $req = $db->prepare("SELECT * FROM `notif` WHERE `id_notifier` = :id_notifier AND `type` = :type AND `user_id` = :user_id", $attributes);
    if ($req)
        return 1;
    return 0;
}

function distance($lat1, $lon1, $lat2, $lon2, $unit) {

    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
        return ($miles * 1.609344);
    } else if ($unit == "N") {
        return ($miles * 0.8684);
    } else {
        return $miles;
    }
}

function get_client_ip()
{
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function gen_token($length)
{
    $tab = "0123456789azertyuiopqsdfghjklmwxcvbn";
    return substr(str_shuffle(str_repeat($tab, $length)), 0, $length);
}

function swap(&$x, &$y) {
    $tmp=$x;
    $x=$y;
    $y=$tmp;
}

function alert_bootstrap($type, $message, $style = "")
{
    return "<div id=\"alert\" class=\"alert alert-{$type}\" style=\"$style\" role=\"alert\">{$message}
            <button type=\"button\" class=\"close\" onclick=\"dismissAlert(this)\" data-dismiss=\"alert\" aria-label=\"Close\">
                <span aria-hidden=\"true\">&times;</span>
            </button>
            </div>";
}

function has_voted($db, $voter, $voted, $vote)
{
    $req = $db->prepare("SELECT * FROM `vote` WHERE `id_voter` = :voter AND `id_voted` = :voted", array("voter" => $voter, "voted" => $voted));
    if ($req) {
        if ($req[0]->type != $vote)
            return 2;
        return 1;
    }
    return 0;
}

function redirection_handler($error)
{
    switch ($error)
    {
        case "block":
            $message = "<b>Access unauthorized:</b> You blocked this user/he blocked you.";
            $type = "warning";
            break;
        case "logg":
            $message = "You're <b>logged in</b>, no need to access this page.";
            $type = "info";
            break;
        case "chat":
            $message = "Access <b>unauthorized</b>!";
            $type = "danger";
            break;
        case "sug":
            $message = "You need to be <b>logged in</b> to access this page!";
            $type = "info";
            break;
        case "reqlog":
           $message = "You need to <b>fill</b> in your <b>gender</b>, <b>orientation</b>, <b>bio</b>, <b>interest tags</b> and have atleast <b>one photo</b>!";
           $type = "info";
           break;
        case "reset":
            $message = "Go to <b>\"Forgot your password?\"</b> to reset your password! We will send you a mail.";
            $type = "info";
            break;
        case "acc":
            $message = "You need to be logged in to access your account!";
            $type = "info";
            break;
        case "pw":
            $message = "<b>You are logged in!</b> Click <a href='account'>here<a> to change your password.";
            $type = "info";
            break;
        case "reg":
            $message = "You cannot create an account while you're <b>logged in!</b>";
            $type = "warning";
            break;
        case "pro":
            $message = "This <b>user</b> does not exist!";
            $type = "warning";
            break;
        case "prolog":
            $message = "You need to be <b>logged in</b>!";
            $type = "info";
            break;
        case "log":
            $message = "You are already <b>logged in</b>!";
            $type = "info";
            break;
        default:
            $message = "ERROR";
            $type = "danger";
    }
    echo $message;
    echo alert_bootstrap("danger", $message, "text-align: center;display: block; position: absolute;top: 6.5%;width: 100%;");
}

function check_length($str, $min, $max)
{
    $len = strlen($str);
    if ($len < $min || $len > $max)
        return false;
    return true;
}

function secure_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}