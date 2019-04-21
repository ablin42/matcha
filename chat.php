<!--
 * Created by PhpStorm.
 * User: ablin
 * Date: 2/21/19
 * Time: 10:18 PM
 * -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Matcha - Chat</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style/bootstrap.css">
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
         roomid = '<?= $_GET['r'] ?>';
    </script>
</head>

<body><!-- onload="setInterval(updateChat('// $_GET['r'] '), 1000)">-->
<?php
require_once("includes/header.php");
require_once("utils/fetch_chat.php");
if (isset($_GET['e']))
    redirection_handler($_GET['e']);
?>

<div class="container mt-5 small-page-wrapper">
    <div class="wrapper col-8 offset-2 p-2">
        <div class="container col-8 p-2 mt-3 mb-3">

            <div id="chat">

                <h1>Chat</h1>

                <p id="name-area"></p>

                <div id="chat-wrap">
                    <div id="chat-area"></div>
                </div>
                <form id="send-message-area" @submit.prevent="sendChat('<?= $_SESSION['id'] ?>', '<?= $_GET['r'] ?>')" class="my-2 my-lg-0" method="post">
                    <p>Your message: </p>
                    <div class="form-group">
                        <textarea v-model="message" id="message" maxlength='100'></textarea>
                    </div>
                    <input type="hidden" id="roomid" value="<?= secure_input($_GET['r']) ?>">
                    <div class="form-group">
                        <button type="submit" name="submit_tags" class="btn btn-outline-warning btn-sign-in">Send</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>

<?php require_once("includes/footer.php");?>
<script src="js/chat.js"></script>
<script src="js/online.js"></script>
<script src="js/notif.js"></script>
<script src="js/ajaxify.js"></script>
<script src="js/alert.js"></script>
</body>
</html>