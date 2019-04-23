<!--/**
 * Created by PhpStorm.
 * User: ablin
 * Date: 3/28/19
 * Time: 4:12 PM
 */-->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Matcha - Search</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style/bootstrap.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
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
?>

<div class="container mt-5 small-page-wrapper">
    <div class="wrapper col-12">
        <h1>Search a profile</h1>
        <div id="sort" class="container" style="margin-top: 0!important;">
            <form name="sort" @submit.prevent="processSort" class="register-form my-2" method="post">
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
                    <label for="gender" class="lab">Gender</label>
                    <select name="gender" v-model="selectedGender" required>
                        <option v-for="gender in genderOptions" v-bind:value="gender.value">
                            {{ gender.text }}
                        </option>
                    </select>
                    <label for="orientation" class="lab">Orientation</label>
                    <select name="orientation" v-model="selectedOrientation" required>
                        <option v-for="orientation in orientationOptions" v-bind:value="orientation.value">
                            {{ orientation.text }}
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
                    <span v-if="errors.byStart" class="requirement_error">The birth year must be in the range 1940-2001</span>
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
                    <span v-if="errors.byEnd" class="requirement_error">The birth year must be in the range 1940-2001</span>
                </div>
                <div class="form-group">
                    <label for="location" class="lab">Maximum distance (in KM)</label>
                    <input type="number"
                           name="location"
                           placeholder="10"
                           id="location"
                           class="form-control"
                           min="1"
                           max="2000"
                           v-model="location"
                           :style="{ borderColor: borderColor.location }"
                           @blur="validateLocation">
                </div>
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
                    <span v-if="errors.pStart" class="requirement_error">The birth year must be in the range 1940-2001</span>
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
                    <span v-if="errors.pEnd" class="requirement_error">The birth year must be in the range 1940-2001</span>
                </div>
                <div class="form-group">
                    <label for="tagInput" class="lab">Tag filter</label>
                    <input type="text" value="" data-role="tagsinput" id="tagInput" name="tagInput" class="form-control">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-outline-warning btn-sign-in">Search</button>
                </div>
            </form>
        </div>
    </div>
        <div id="suggestion">
            <div id="gen-sugg">
            </div>
        </div>
</div>

<?php require_once("includes/footer.php");?>
<script src="js/online.js"></script>
<script src="vuejs/search.js"></script>
<script src="js/notif.js"></script>

<script src="js/alert.js"></script>
</body>
</html>