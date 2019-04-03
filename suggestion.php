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
    <script src="js/bootstrap-tagsinput.js"></script>
</head>

<body>
<?php
require_once("includes/header.php");
require_once("utils/fetch_account_data.php");

if (!isset($_SESSION['logged']) && $_SESSION['logged'] !== 1)
    header('Location: /Matcha/?e=sug');
if ($gender == NULL || $orientation == NULL || $bio == NULL || $tags == NULL ||
    ($photos[0] == NULL && $photos[1] == NULL && $photos[2] == NULL && $photos[3] == NULL && $photos[4] == NULL))
        header('Location: /Matcha/Account?e=reqlog');
?>

<div class="container mt-5 small-page-wrapper">
    <div class="wrapper col-12">
        <h1>Profiles you might be interested in</h1>
        <div class="container">
        <form id="sort" name="sort" @submit.prevent="processSort" class="register-form my-2" method="post">
            <div class="form-group">
                <label for="sort" class="lab">Sort Type</label>
                <select name="sort" v-model="selectedSort" required>
                    <option v-for="sort in sortOptions" v-bind:value="sort.value">
                        {{ sort.text }}
                    </option>
                </select>
                <select name="order" v-model="selectedOrder" required>
                    <option v-for="order in orderOptions" v-bind:value="order.value">
                        {{ order.text }}
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label for="bystart" class="lab">Birth year <b>start</b></label>
                <input type="number"
                       name="bystart"
                       placeholder="1940"
                       id="bystart"
                       class="form-control"
                       min="1940"
                       max="2000"
                       v-model="byStart"
                       :style="{ borderColor: borderColor.byStart }"
                       @blur="validateByStart">
                <span v-if="errors.byStart">The birth year must be in the range 1940-2001</span>
            </div>
            <div class="form-group">
                <label for="byend" class="lab">Birth year <b>end</b></label>
                <input type="number"
                       name="byend"
                       placeholder="2001"
                       id="byend"
                       class="form-control"
                       min="1941"
                       max="2001"
                       v-model="byEnd"
                       :style="{ borderColor: borderColor.byEnd }"
                       @blur="validateByEnd">
                <span v-if="errors.byEnd">The birth year must be in the range 1940-2001</span>
            </div>
            <!--<div class="form-group">
                <label for="location" class="lab">Location</label>
                <input type="text" class="form-control" disabled />
            </div>-->
            <div class="form-group">
                <label for="pstart" class="lab">Minimum popularity score</label>
                <input type="number"
                       name="pstart"
                       placeholder="0"
                       id="pstart"
                       class="form-control"
                       min="-100000"
                       max="100000"
                       v-model="pStart"
                       :style="{ borderColor: borderColor.pStart }"
                       @blur="validatepStart">
                <span v-if="errors.pStart">The popularity score must be between -100.000 and 100.000</span>
            </div>
            <div class="form-group">
                <label for="pend" class="lab">Maximum popularity score</label>
                <input type="number"
                       name="pend"
                       placeholder="250"
                       id="pend"
                       class="form-control"
                       min="-100000"
                       max="100000"
                       v-model="pEnd"
                       :style="{ borderColor: borderColor.pEnd }"
                       @blur="validatepEnd">
                <span v-if="errors.pEnd">The popularity score must be between -100.000 and 100.000</span>
            </div>
            <div class="form-group">
                <label for="tagInput" class="lab">Tag filter</label>
                <input v-model="selectedTags" type="text" value="" data-role="tagsinput" id="tagInput" name="tagInput" class="form-control">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-outline-warning">Sort</button>
            </div>
        </form>
        </div>
        <div id="suggestion">
            <?php
                require_once("utils/fetch_suggestion.php");
                foreach ($sorted as $match)
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
        </div>
    </div>
</div>

<?php require_once("includes/footer.php");?>
<script src="js/online.js"></script>
<script src="vuejs/suggestion.js"></script>
<script src="js/ajaxify.js"></script>
<script src="js/alert.js"></script>
</body>
</html>