<!--
/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 3/27/19
 * Time: 6:06 PM
 */-->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Matcha - Activity</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style/bootstrap.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
<?php
require_once("includes/header.php");
require_once("utils/fetch_activity.php");
if (!isset($_SESSION['logged']) && $_SESSION['logged'] !== 1)
    header('Location: /Matcha/?e=reqlog');
?>

<div class="container mt-5 small-page-wrapper">
    <div class="wrapper col-12">
        <h1>Recent activity</h1>
        <?php
            foreach ($matched as $user) {
                echo "<p><i>".$user[0]->date."</i>: ";
                echo "<a href='/Matcha/profile?u=".$user['username']."'>".$user['username']."</a> liked you back</p>";
            }
            foreach ($likes as $like) {
                echo "<p><i>".$like->date."</i>: <a href='/Matcha/profile?u=".$like->username."'>";
                echo "".$like->username."</a> liked your profile!</p>";
            }
            foreach ($visits as $visit) {
                echo "<p><i>".$visit->date."</i>: <a href='/Matcha/profile?u=".$visit->username."'>";
                echo "".$visit->username."</a> visited your profile</p>";
            }
        ?>
    </div>
</div>

<?php require_once("includes/footer.php");?>
<script src="js/online.js"></script>
<script src="js/ajaxify.js"></script>
<script src="js/alert.js"></script>
</body>
</html>