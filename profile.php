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
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
</head>

<body>
<?php
require_once("includes/header.php");
require_once("utils/fetch_profile_data.php");
if (!isset($_SESSION['logged']) && $_SESSION['logged'] !== 1)
    header('Location: /Matcha/?e=prolog');
if ($id === $_SESSION['id'])
    header('Location: /Matcha/account');//might show preview
?>

<div class="container mt-5 small-page-wrapper">
    <div class="wrapper col-12">
        <h1><?= $username ?></h1>
        <div class="col-12">
            <?php
                for ($i = 0; $i < 5; $i++) {
                    if ($photos[0] != NULL && $i === 0)
                        echo '<img src="'. $photos[$i] .'" alt="photo'.$i.'" class="profile_main"/>';
                    else if ($photos[$i] != NULL)
                        echo '<img src="'. $photos[$i] .'" alt="photo'.$i.'" class="profile_secondary"/>';
                }
            ?>

        </div>
        <div class="col-6">
            <p><?= $firstname . " <b>" . $lastname . "</b>"?>, born in <b><?= $birth_year ?></b></p>
            <p>Gender: <b><?= $gender ?></b></p>
            <p>Sexual Orientation: <b><?= $orientation ?></b></p>
            <div>
                <h4 style="text-align: left;">Interested in:</h4>
                <?php
                    foreach ($tags as $tag) {
                        echo "<div class='profile_tag'><p>" . $tag . "</p></div> ";
                    }
                ?>
            </div>
            <p>
                <b><?= $firstname ?>'s bio:</b>
                <?= $bio ?>
            </p>
        </div>
        <div id="report-btn">
            <?php if (!$report)
                echo '<a v-if="!reported" href="#" @click.prevent="reportUser('. $id .')" class="report-btn">Report as fake user</a>';
            ?>
        </div>
        <div id="vote">
        <?php if ($photos[0] != NULL || $photos[1] != NULL || $photos[2] != NULL || $photos[3] != NULL || $photos[4]!= NULL)
            {
                if (has_voted($db, secure_input($id), secure_input($_SESSION['id']), 1) === 1)
                    echo alert_bootstrap("info", "<b>$username</b> has liked your profile, you can like back this profile.. or not!", "text-align: center;");
                echo "  <button @click=\"vote(".$id.", 1)\" class=\"btn-like\">
                            <i class=\"fas fa-heart fa-4x like";
                if (has_voted($db, secure_input($id), secure_input($_SESSION['id']), 1) === 1)
                    echo " liked";
                echo "\"></i>
                        </button>
                        <button @click=\"vote(".$id.", -1)\" class=\"btn-like\">
                            <i class=\"fas fa-heart-broken fa-4x like\"></i>
                        </button>";
            }?>
        </div>
        <div id="popularity">
            <h2>Popularity score:</h2>
            <h1><?= $score ?></h1>
        </div>
    </div>
</div>

<?php require_once("includes/footer.php");?>
<script src="vuejs/profile.js"></script>
<script src="js/ajaxify.js"></script>
<script src="js/alert.js"></script>
</body>
</html>