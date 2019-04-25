<?php
/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 3/25/19
 * Time: 5:45 PM
 */
session_start();
use \ablin42\database;
use \ablin42\autoloader;
require ("../class/autoloader.php");
require_once("../utils/functions.php");
autoloader::register();
$db = database::getInstance('matcha');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'));
    if (!empty($data->{'function'}))
    {
        $function = secure_input($data->{'function'});
        switch ($function){
            case('update'):
                if (!empty($data->{'roomid'})) {
                    $attributes['roomid'] = secure_input($data->{'roomid'});
                    $req = $db->prepare("SELECT * FROM `chat` WHERE `roomid` = :roomid", $attributes);
                    foreach ($req as $msg) {
                        echo "<div class=\"message";
                        echo '"';
                        echo "><div class='";
                        if ($msg->username != $_SESSION['username']) 
                            echo "sent_user";
                        else
                            echo "received_user";
                        echo "'>";
                        echo "".ucfirst($msg->username)."</div><p class='";
                        if ($msg->username != $_SESSION['username']) 
                            echo "sent_message";
                        else
                            echo "received_message";
                        echo "'>";
                        echo "".$msg->message."</p>";
                        echo "<p class =\"";
                        if ($msg->username != $_SESSION['username']) 
                            echo "sent_date";
                        else
                         echo "received_date";
                        echo '">';
                        echo $msg->date;
                        echo "</p></div>";
                    }
                }
                break;

            case('send'):
                if (!empty($data->{'roomid'}) && !empty($data->{'message'}) && !empty($_SESSION['id']) && !empty($_SESSION['username'])){
                    $attributes['roomid'] = secure_input($data->{'roomid'});
                    $attributes['id'] = secure_input($_SESSION['id']);
                    $attributes['username'] = secure_input($_SESSION['username']);
                    $attributes['message'] = secure_input($data->{'message'});
                    $db->prepare("INSERT INTO `chat` (`roomid`, `user_id`, `username`, `message`, `date`)
                                                   VALUES (:roomid, :id, :username, :message, NOW())", $attributes);
                    $req = $db->prepare("SELECT * FROM `chatroom` WHERE `roomid` = :roomid", array("roomid" => $attributes['roomid']));
                    if ($req){
                        foreach ($req as $item) {
                            $user1 = $item->user1_id;
                            $user2 = $item->user2_id;
                        }
                    }
                    $user = $user1;
                    if ($attributes['id'] === $user1)
                        $user = $user2;
                    $notify['id'] = $user;
                    $notify['notifier'] = $attributes['id'];
                    $username = ucfirst(secure_input($_SESSION['username']));
                    $notify['body'] = "<a onclick='notifRedirect(event, this);' href='profile?u=".urlencode($username)."'>".$username."</a> <b>sent</b> you a message!";

                    $db->prepare("INSERT INTO `notif` (`id_notifier`, `user_id`, `type`, `body`, `date`) VALUES (:notifier, :id, 'message',:body, NOW())", $notify);
                }
                break;
        }
    }
    else
        alert_bootstrap("warning" , "A <b>field</b> is empty", "text-align: center;");
}
else
    alert_bootstrap("danger" , "Not a <b>post</b> request.", "text-align: center;");
