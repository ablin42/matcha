<?php

function gen_token($length)
{
    $tab = "0123456789azertyuiopqsdfghjklmwxcvbn";
    return substr(str_shuffle(str_repeat($tab, $length)), 0, $length);
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
        case "reqlog":
            echo alert_bootstrap("info", "You need to be <b>logged in</b> to access this page!", "text-align: center;");
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