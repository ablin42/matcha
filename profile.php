<!--/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 3/25/19
 * Time: 6:56 PM
 */-->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Matcha - Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style/bootstrap.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
</head>

<body>
<?php
require_once("includes/header.php");
require_once("utils/fetch_profile_data.php");
?>

<div class="container mt-5">
    <div class="wrapper col-12">
        <h1><?= $username ?></h1>
        <div class="col-12">
            <img src="<?= $photos[0] ?>" alt="profile picture" class="profile_main" />
            <img src="<?= $photos[1] ?>" alt="photo2" class="profile_secondary"/>
            <img src="<?= $photos[2] ?>" alt="photo3" class="profile_secondary"/>
            <img src="<?= $photos[3] ?>" alt="photo4" class="profile_secondary"/>
            <img src="<?= $photos[4] ?>" alt="photo5" class="profile_secondary"/>
        </div>
        <div class="col-6">
            <p></p>
        </div>
    </div>
</div>

<?php require_once("includes/footer.php");?>
<script src="js/ajaxify.js"></script>
<script src="js/alert.js"></script>
</body>
</html>