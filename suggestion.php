<!--/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 3/28/19
 * Time: 4:12 PM
 */-->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Matcha - Suggestions</title>
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
require_once("utils/fetch_account_data.php");

if (!isset($_SESSION['logged']) && $_SESSION['logged'] !== 1)
    header('Location: /Matcha/?e=sug');
?>

<div class="container mt-5 small-page-wrapper">
    <div class="wrapper col-12">
        <h1>Profiles you might be interested in</h1>
        <?php
            if ($gender == NULL || $orientation == NULL || $bio == NULL || $tags == NULL ||
                ($photos[0] == NULL && $photos[1] == NULL && $photos[2] == NULL && $photos[3] == NULL && $photos[4] == NULL)) {
                header('Location: /Matcha/Account?e=reqlog');
            }
          ?>
        <p>
            <?php
                require_once("utils/fetch_suggestion.php");
                foreach ($sortedbytagscore as $match)
                {
                    echo "<div style='border: 1px solid red;'>";
                    if ($match['profile_pic'])
                        echo "<img class='profile_main' alt='profile_picture' src='".$match['profile_pic']."' />";
                    echo "<p><a href='/Matcha/profile?u=".$match[1]."'>".$match[1]."</a>, <i>".$match[2].", ".$match[3]."</i></p>";
                    echo "<p>Popularity score: <b>".$match['score']."</b></p>";
                    echo "<p>You're both interested in: </p>";
                    foreach ($match['tags'] as $tag)
                        echo "<div class='profile_tag'><p>".$tag."</p></div>";
                    echo "</div><br />";
                }
            ?>

        </p>
    </div>
</div>

<?php require_once("includes/footer.php");?>
<script src="js/online.js"></script>
<script src="js/ajaxify.js"></script>
<script src="js/alert.js"></script>
</body>
</html>