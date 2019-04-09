<?php
use \ablin42\database;
$db = database::getInstance('matcha');

if (!empty($_GET['r'])){
    $userid = secure_input($_SESSION['id']);
    $attributes['roomid'] = secure_input($_GET['r']);
    $req = $db->prepare("SELECT * FROM `chatroom` WHERE `roomid` = :roomid", $attributes);
    if ($req){
        foreach ($req as $item){
            $user1 = $item->user1_id;
            $user2 = $item->user2_id;
            if ($userid != $user1 && $userid != $user2)
                header('Location: /Matcha/?e=chat');
        }
    }
    if (has_voted($db, $user1, $user2, 1) !== 1 || has_voted($db, $user2, $user1, 1) !== 1)
        header('Location: /Matcha/?e=chat');
    $req = $db->prepare("SELECT * FROM `chat` WHERE `roomid` = :roomid", $attributes);
}