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
            foreach ($visits as $visit)
            {
                echo "<p><a href='/Matcha/profile?u=".$visit->username."'>
                ".$visit->username."</a> visited your profile the <i>".$visit->date."</i></p>";
            }
        ?>
    </div>
</div>

<?php require_once("includes/footer.php");?>
<script src="js/ajaxify.js"></script>
<script src="js/alert.js"></script>
</body>
</html>