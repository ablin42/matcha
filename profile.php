<!--/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 3/25/19
 * Time: 6:56 PM
 */-->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Matcha - <?= ucwords($_GET['u']); ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style/bootstrap.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
<?php
require_once("includes/header.php");
require_once("utils/fetch_profile_data.php");
if (!isset($_SESSION['logged']) && $_SESSION['logged'] !== 1)
    header('Location: /Matcha/?e=prolog');
?>

<div class="container mt-5 small-page-wrapper">
    <div class="wrapper col-12">
            <?php
            if (has_voted($db, secure_input($id), secure_input($_SESSION['id']), 1) === 1 && has_voted($db, secure_input($_SESSION['id']),secure_input($id), 1) === 1)
                echo "<h5>You matched with <b class='username'>" . $username . "</b>! Click <a href='chat?r=".$roomid."'>here</a> to send a message</h5>";
            else if (has_voted($db, secure_input($id), secure_input($_SESSION['id']), 1) === 1 && has_voted($db, secure_input($_SESSION['id']),secure_input($id), -1) === 1)
                echo "<h5><b class='username'>".$username."</b> liked your profile and you disliked <b class='username'>".$username."</b>'s profile</h5>";
            else if (has_voted($db, secure_input($id), secure_input($_SESSION['id']), -1) === 1 && has_voted($db, secure_input($_SESSION['id']),secure_input($id), -1) === 1)
                echo "<h5>You disliked eachothers</h5>";
            else if (has_voted($db, secure_input($id), secure_input($_SESSION['id']), 1) === 1 && has_voted($db, secure_input($_SESSION['id']),secure_input($id), 1) !== 1)
                echo "<h5><b class='username'>".$username."</b> liked your profile</h5>";
            else if (has_voted($db, secure_input($_SESSION['id']),secure_input($id), -1) === 1)
                echo "<h5>You disliked <b class='username'>".$username."</b>'s profile</h5>";
            else if (has_voted($db, secure_input($_SESSION['id']), secure_input($id), 1) === 1)
                echo "<h5>You liked <b class='username'>".$username."</b>'s profile</h5>";
            ?>
            <h6><?= $status ?></h6>
            <h3 class="username d-inline-block"><?= $username ?>,</h3>
            <?php
                if ($distance)
                    echo "<h5 class='d-inline-block'>".$distance."KM away</h5>"; ?>
        <div class="row">
            <div class="col-4">
                <div class="profile_left">
                <?php
                    if ($photos[0] && $photos[0] !== "null")
                        echo '<img src="'. $photos[0] .'" alt="photo0" class="profile_main"/>';

                    echo "<div class='row no-gutters'>";
                    for ($i = 1; $i < 5; $i++) {
                        if ($photos[$i] && $photos[$i] !== "null")
                            echo '<div class="col-6 p-1"><img src="'. $photos[$i] .'" alt="photo'.$i.'" class="profile_secondary"/></div>';
                    }
                    echo "</div>";
                ?>
                </div>
        </div>

            <div class="col-6">
                <p><?= $firstname . " <b>" . $lastname . "</b> "?>(<?= $birth_year ?>)</p>
                <p><?= $gender ?>, <?= $orientation ?></p>
                <p>
                    <b><?= $firstname ?>'s bio:</b><br />
                    <?= $bio ?>
                </p>
                <div>
                    <?php
                    foreach ($tags as $tag) {
                        echo "<div class='matched_tag'><p>" . $tag . "</p></div> ";
                    }
                    ?>
                </div>
                <div id="vote" class="text-center">
                    <?php if (($photos[0] != NULL || $photos[1] != NULL || $photos[2] != NULL || $photos[3] != NULL || $photos[4]!= NULL) &&
                        ($photos_curr_user[0] != NULL || $photos_curr_user[1] != NULL || $photos_curr_user[2] != NULL || $photos_curr_user[3] != NULL || $photos_curr_user[4]!= NULL))
                    {
                        echo "<button id='like-btn' @click=\"vote(".$id.", 1)\" class=\"btn-like\">
                            <i class=\"fas fa-heart fa-8x like";
                        if (has_voted($db, secure_input($_SESSION['id']),secure_input($id), 1) === 1)
                            echo " liked";
                        echo "\"></i>
                        </button>
                        <p style=\"font-size: 220px; display: inline-block\">/</p>
                        <button id='dislike-btn' @click=\"vote(".$id.", -1)\" class=\"btn-like\">
                            <i class=\"fas fa-heart-broken fa-8x dislike";
                        if (has_voted($db, secure_input($_SESSION['id']), secure_input($id), -1) === 1)
                            echo " disliked";
                        echo "\"></i>
                        </button>";
                    }?>
                </div>
            </div>
            <div class="rep-block-btn col-4">
                <div id="report-btn" class="d-inline-block">
                    <?php if (!$report)
                        echo '<a v-if="!reported" href="#" @click.prevent="reportUser('. $id .')" class="report-btn"><i class="far fa-flag"></i> Report </a>';
                    ?>
                </div>
                <div id="block-btn" class="d-inline-block">
                    <?php
                    echo '<a id="block" href="#" @click.prevent="blockUser('. $id .')" class="report-btn"><i class="fas fa-ban"></i> '.$block.'</a>';
                    ?>
                </div>
            </div>
        </div>

        <div id="popularity">
            <h1 style="font-size: 60px;"><?= $score ?></h1>
        </div>
    </div>
</div>

<?php require_once("includes/footer.php");?>
<script src="js/online.js"></script>
<script src="vuejs/profile.js"></script>
<script src="js/notif.js"></script>

<script src="js/alert.js"></script>
</body>
</html>