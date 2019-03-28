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
use \ablin42\database;
if (!isset($_SESSION['logged']) && $_SESSION['logged'] !== 1)
    header('Location: /Matcha/?e=acc');
if (isset($_GET['e']))
    redirection_handler($_GET['e']);
require_once("utils/fetch_account_data.php");
?>
<div class="container mt-5 small-page-wrapper">
    <div class="wrapper col-12 p-2">
        <h1>profile settings</h1>
        <div class="gallery-wrapper">
        <div class="register-form-wrapper container col-6 p-3 mt-3 mb-3">
            <form id="infos" name="infos" @submit.prevent="processForm" class="my-2 my-lg-0" method="post">
                {{ assignGender(<?= json_encode($gender) ?>) }}
                {{ assignOrientation(<?= json_encode($orientation) ?>) }}
                {{ assignBio(<?= json_encode($bio) ?>) }}
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
                    <button type="submit" name="submit_tags" class="btn btn-outline-warning btn-sign-in">Update tags</button>
                </div>
            </form>

            <div id="photos">
                <photo-upload <?php if ($photos[0]) echo "v-bind:db-path=' $photos[0] '";?> v-bind:id-component="1" btn="Profile picture"></photo-upload>
                <photo-upload <?php if ($photos[1]) echo "v-bind:db-path=' $photos[1] '";?> v-bind:id-component="2" btn="Photo 2"></photo-upload>
                <photo-upload <?php if ($photos[2]) echo "v-bind:db-path=' $photos[2] '";?> v-bind:id-component="3" btn="Photo 3"></photo-upload>
                <photo-upload <?php if ($photos[3]) echo "v-bind:db-path=' $photos[3] '";?> v-bind:id-component="4" btn="Photo 4"></photo-upload>
                <photo-upload <?php if ($photos[4]) echo "v-bind:db-path=' $photos[4] '";?> v-bind:id-component="5" btn="Photo 5"></photo-upload>
            </div>
        </div>
        </div>

        <hr />
        <h1>account settings</h1>
        <div class="gallery-wrapper">
            <div class="register-form-wrapper container col-6 p-3 mt-3 mb-3">
                <form id="account" name="account" @submit.prevent="processForm" class="my-2 my-lg-0" method="post">
                    {{ assignFirstname("<?= $firstname ?>") }}
                    {{ assignLastname("<?= $lastname ?>") }}
                    {{ assignUsername("<?= $username ?>") }}
                    {{ assignEmail("<?= $email ?>") }}
                    <div class="form-group">
                        <label for="firstname" class="lab">First Name</label>
                        <input type="text"
                               name="firstname"
                               placeholder="John"
                               id="firstname"
                               class="form-control"
                               maxlength="16"
                               v-model="firstname"
                               :style="{ borderColor: borderColor.firstname }"
                               @blur="validateFirstname"
                               required>
                        <span v-if="errors.firstname">First name must contain between 2 and 16 characters</span>
                    </div>
                    <div class="form-group">
                        <label for="lastname" class="lab">Last Name</label>
                        <input type="text"
                               name="lastname"
                               placeholder="Doe"
                               id="lastname"
                               class="form-control"
                               maxlength="16"
                               v-model="lastname"
                               :style="{ borderColor: borderColor.lastname }"
                               @blur="validateLastname"
                               required>
                        <span v-if="errors.lastname">Last name must contain between 2 and 16 characters</span>
                    </div>
                    <div class="form-group">
                        <label for="username" class="lab">Username</label>
                        <input type="text"
                               name="username"
                               placeholder="ablin42"
                               id="username"
                               class="form-control"
                               maxlength="30"
                               v-model="username"
                               :style="{ borderColor: borderColor.username }"
                               @blur="validateUsername"
                               required>
                        <span v-if="errors.username">Username must contain between 4 and 30 characters</span>
                    </div>
                    <div class="form-group">
                        <label for="email" class="lab">E-mail</label>
                        <input type="email"
                               name="email"
                               placeholder="ablin42@byom.de"
                               id="email" class="form-control"
                               maxlength="255"
                               v-model="email"
                               :style="{ borderColor: borderColor.email }"
                               @blur="validateEmail"
                               required>
                        <span v-if="errors.email">E-mail has to be valid</span>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit_account" class="btn btn-outline-warning btn-sign-in">Update</button>
                    </div>
                </form>
            </div>
        </div>

        <hr />
        <h1>security</h1>
        <div class="gallery-wrapper">
            <div class="register-form-wrapper container col-6 p-3 mt-3 mb-3">
                <form id="security" name="security" @submit.prevent="processForm" class="my-2 my-lg-0" method="post">
                    <div class="form-group">
                        <label for="currpw" class="lab">Current password</label>
                        <input type="password"
                               name="currpw"
                               placeholder="********"
                               id="currpw"
                               class="form-control"
                               maxlength="30"
                               v-model="currpw"
                               required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="lab">New password</label>
                        <input type="password"
                               name="password"
                               placeholder="********"
                               id="password"
                               class="form-control"
                               maxlength="30"
                               v-model="password"
                               :style="{ borderColor: borderColor.password }"
                               @blur="validatePassword"
                               required>
                        <span v-if="errors.password">Password must contain between 8 and 30 characters and has to be atleast alphanumeric</span>
                    </div>
                    <div class="form-group">
                        <label for="password2" class="lab">Confirm your new password</label>
                        <input type="password"
                               name="password2"
                               placeholder="********"
                               id="password2"
                               class="form-control"
                               maxlength="30"
                               v-model="password2"
                               :style="{ borderColor: borderColor.password2 }"
                               @blur="validatePassword2"
                               required>
                        <span v-if="errors.password2">Password has to be the same as the one you just entered</span>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit_account" class="btn btn-outline-warning btn-sign-in">Change password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
require_once("includes/footer.php");
if ($tags)
{
    echo "<script>
          $(document).ready(function(){

          let tags =  $tags ,
          tagInput = $('#tagInput');
          
          tagInput.on('beforeItemRemove', function(event) {
              let tag = event.item;
              fetch('handlers/delete_tag.php', {
                  method: 'post',
                  mode: 'same-origin',
                  body: JSON.stringify({tag: tag})
              })
                  .then((res) => res.text())
                  .then((data) => addAlert(data, document.getElementById('header')))
                  .catch((error) => console.log(error))
          });
          for (i = 0; i < tags.length; i++)
            tagInput.tagsinput('add', tags[i]);
    });
</script>";
}
?>
<script src="vuejs/account.js"></script>
<script src="js/ajaxify.js"></script>
<script src="js/alert.js"></script>
</body>
</html>