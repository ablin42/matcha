<!--
/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 3/5/19
 * Time: 10:44 PM
 */
 -->

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Matcha - Profile settings</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style/bootstrap.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/bootstrap-tagsinput.js"></script>
    <script src="https://unpkg.com/@johmun/vue-tags-input/dist/vue-tags-input.js"></script>
</head>

<body>
<?php
require_once("includes/header.php");
if (!isset($_SESSION['logged']) && $_SESSION['logged'] !== 1)
    header('Location: /Matcha/?e=acc');
use \ablin42\database;
$db = database::getInstance('matcha');
$req = $db->prepare("SELECT * FROM `user_info` WHERE `user_id` = :user_id", array("user_id" => secure_input($_SESSION['id'])));
if ($req)
    foreach ($req as $item)
    {
        $gender = $item->gender;
        $orientation = $item->orientation;
        $bio = $item->bio;
    }
?>

<div class="container mt-5 small-page-wrapper">
    <div class="wrapper col-12 p-2">
        <h1>profile settings</h1>
        <div class="gallery-wrapper">
        <div class="register-form-wrapper container col-6 p-3 mt-3 mb-3">
            <form id="infos" name="infos" @submit.prevent="processForm" class="my-2 my-lg-0" method="post">
                {{ assignGender("<?= $gender ?>") }}
                {{ assignOrientation("<?= $orientation ?>") }}
                {{ assignBio("<?= $bio ?>") }}
                <div class="form-group">
                    <label for="gender" class="lab">Gender</label>
                    <select v-model="selectedGender" required>
                        <option disabled value="">Please select one</option>
                        <option v-for="gender in genderOptions" v-bind:value="gender.value">
                            {{ gender.text }}
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="orientation" class="lab">Sexual Orientation</label>
                    <select v-model="selectedOrientation" required>
                        <option disabled value="">Please select one</option>
                        <option v-for="orientation in orientationOptions" v-bind:value="orientation.value">
                            {{ orientation.text }}
                        </option>-
                    </select>
                </div>

                <div class="form-group" id="tests">
                    <label for="bio" class="lab">A short paragraph about yourself</label>
                    <textarea maxlength="512" v-model="bio" placeholder="Your bio here..." required></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" name="submit_infos" class="btn btn-outline-warning btn-sign-in">Update Infos</button>
                </div>
            </form>

            <form id="tags" name="tags" @submit.prevent="processForm" class="my-2 my-lg-0" method="post">
                <div class="form-group">
                    <input v-bind="selectedTags" type="text" value="" data-role="tagsinput" id="tagInput" class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" name="submit_infos" class="btn btn-outline-warning btn-sign-in">Update tags</button>
                </div>
            </form>

            <div id="photos">
                <photo-upload v-bind:id-component="1"></photo-upload>
                <photo-upload v-bind:id-component="2"></photo-upload>
                <photo-upload v-bind:id-component="3"></photo-upload>
                <photo-upload v-bind:id-component="4"></photo-upload>
                <photo-upload v-bind:id-component="5"></photo-upload>
            </div>
        </div>
        </div>
    </div>
</div>


<?php require_once("includes/footer.php");?>
<script src="vuejs/accountForms.js"></script>
<script src="js/ajaxify.js"></script>
<script src="js/alert.js"></script>
</body>
</html>