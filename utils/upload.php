<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_upload']) && !empty($_FILES['picture']))
{
    $max_file_size = 2000000;
    $id = $_SESSION['id'];
    if($_FILES['picture']['error'] > 0)
    {
        echo alert_bootstrap("danger", "An <b>error</b> occured during the upload! Please, try again.", "text-align: center;");
        return ;
    }

    if($_FILES['picture']['size'] > $max_file_size)
    {
        echo alert_bootstrap("danger", "<b>Error:</b> The file you select is too big (> 2MB).", "text-align: center;");
        return ;
    }

    $valid_extensions = array('jpg', 'jpeg', 'png');
    $extension_upload = strtolower(substr(strrchr($_FILES['picture']['name'],'.'),1));
    if (!in_array($extension_upload, $valid_extensions))
    {
        echo alert_bootstrap("danger", "<b>Error:</b> File extension is not valid! <b>(Extension authorized: jpg, jpeg, gif, png)</b>", "text-align: center;");
        return ;
    }

    $image_size = getimagesize($_FILES['picture']['tmp_name']);
    if ($image_size[0] != 0 && $image_size[1] != 0 && $image_size[0] < $image_size[1])
    {
        echo alert_bootstrap("danger", "<b>Error:</b> File dimensions aren't valid! <b>(height has to be smaller than width!)</b>", "text-align: center;");
        return ;
    }

    $filename = gen_token(40);
    $path = "tmp/{$filename}.{$extension_upload}";
    move_uploaded_file($_FILES['picture']['tmp_name'], $path);
    ?>
    <script>
        var img = document.createElement("img");
        img.setAttribute('src', "<?php echo $path; ?>");
        img.setAttribute('id', 'video');
        img.setAttribute('alt', 'your picture');
        img.setAttribute('class', "col-10 offset-1");

        document.getElementById('video').remove();
        var where = document.getElementById("video-div");
        where.appendChild(img);
    </script>
    <?php
}
?>