<?php

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

function mail_on_comment($db, $id_img)
{

    $req = $db->prepare("SELECT * FROM `image` LEFT JOIN `user` ON image.id_user = user.id WHERE image.id = :id", array('id' => $id_img));
    foreach ($req as $item)
    {
        if ($item->mail_notify == 1)
        {
            $subject = "Camagru - Someone commented one of your picture";
            $message = "The picture you posted at http://localhost:8080/Camagru/image?id={$id_img} got a comment!";
            mail($item->email, $subject, $message);
        }
    }
}

function notif_state($db, $id)
{
    $req = $db->prepare("SELECT `mail_notify` FROM `user` WHERE `id` = :id", array("id" => $id));
    foreach ($req as $item)
    {
        if ($item->mail_notify == 1)
            return true;
        else
            return false;
    }
}

function scrolling_state($db, $id)
{
    $req = $db->prepare("SELECT `infinite_scroll` FROM `user` WHERE `id` = :id", array("id" => $id));
    foreach ($req as $item)
    {
        if ($item->infinite_scroll == 1)
            return true;
        else
            return false;
    }
}

function redirection_handler($error)
{
    switch ($error)
    {
        case "sug":
            echo alert_bootstrap("info", "You need to be <b>logged in</b> to access this page!", "text-align: center;");
            break;
        case "reqlog":
            echo alert_bootstrap("info", "You need to <b>fill</b> in your <b>gender</b>, <b>orientation</b>, <b>bio</b>, <b>interest tags</b> and have atleast <b>one photo</b>!", "text-align: center;");
            break;
        case "reset":
            echo alert_bootstrap("info", "Go to <b>\"Forgot your password?\"</b> to reset your password! We will send you a mail.", "text-align: center;");
            break;
        case "acc":
            echo alert_bootstrap("info", "You need to be <b>logged in</b> to access your account!", "text-align: center;");
            break;
        case "pw":
            echo alert_bootstrap("info", "<b>You are logged in!</b> Click <a href='account'>here<a> to change your password.", "text-align: center;");
            break;
        case "reg":
            echo alert_bootstrap("info", "You cannot create an account while you're <b>logged in!</b>", "text-align: center;");
            break;
        case "pro":
            echo alert_bootstrap("info", "This <b>user</b> does not exist!", "text-align: center;");
            break;
        case "prolog":
            echo alert_bootstrap("info", "You need to be <b>logged in</b> to see other's profile!", "text-align: center;");
            break;
        case "log":
            echo alert_bootstrap("info", "You are already <b>logged in!</b>", "text-align: center;");
            break;
        default:
            echo alert_bootstrap("danger", "ERROR!", "text-align: center;");
    }
}

function get_filter_position($filtername)
{
    $info = array();

    if ($filtername === "solomonk.png" || $filtername === "rdv.png" || $filtername === "comte.png"
        || $filtername === "gein.png" || $filtername === "ouga.png" || $filtername === "ben.png")
    {
        $info['src_w'] = 200;
        $info['src_h'] = 200;
        $info['dst_x'] = 200;
        $info['dst_y'] = 0;
    }
    else if ($filtername === "ivoire.png" || $filtername === "ebene.png" || $filtername === "ocre.png")
    {
        $info['src_w'] = 200;
        $info['src_h'] = 200;
        $info['dst_x'] = 400;
        $info['dst_y'] = 150;
    }
    else if ($filtername === "emeraude.png" || $filtername === "turquoise.png" || $filtername === "pourpre.png")
    {
        $info['src_w'] = 200;
        $info['src_h'] = 200;
        $info['dst_x'] = 0;
        $info['dst_y'] = 150;
    }
    return $info;
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