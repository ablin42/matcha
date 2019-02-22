<?php
require_once("functions.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['img_url']) && !empty($_POST['filter']) && !empty($_POST['infos']) && !empty($_POST['width']) && !empty($_POST['height']))
{
    $img_url = $_POST['img_url'];
    $width = $_POST['width'];
    $height = $_POST['height'];
    $decodedInfos = json_decode($_POST['infos']);

    if (strpos($img_url, "data") !== false)
    {
        $encodedData = substr(htmlspecialchars(trim($img_url)), 22);
        $encodedData = str_replace(' ', '+', $encodedData);
        $data = base64_decode($encodedData);
        $photo = imagecreatefromstring($data);
    }
    else
    {
        $img_url = "../{$img_url}";
        if (strpos($img_url, ".png") == true)
            $photo = imagecreatefrompng($img_url);
        else if (strpos($img_url, ".jpg") == true || strpos($img_url, ".jpeg") == true)
            $photo = imagecreatefromjpeg($img_url);
    }

    list($src_width, $src_height) = getimagesize($img_url);
    $img_resized = imagecreatetruecolor($width, $height);
    imagecopyresampled($img_resized, $photo, 0, 0, 0, 0, $width, $height, $src_width, $src_height);
    if (strpos($img_url, "data") !== false)
        $img_resized = $photo;

    $filters = explode(',', $_POST['filter']);
    $filters_name = $filters;
    $i = 0;
    foreach ($filters as $item) {
        $filters[$i] = imagecreatefrompng("../filters/{$item}");
        $i++;
    }
    foreach ($filters as $filter)
        imagesavealpha($filter, true);
    imagealphablending($img_resized, true);

    $i = 0;
    foreach ($filters as $filter) {
        $info = get_filter_position($filters_name[$i]);
        imagecopy($img_resized, $filter, $decodedInfos[$i]->left, $decodedInfos[$i]->top, 0, 0, $decodedInfos[$i]->width, ceil($decodedInfos[$i]->height));
        imagedestroy($filter);
        $i++;
    }

    $filename = gen_token(40);
    $filename = "../tmp/{$filename}.png";
    imagepng($img_resized , $filename);
    $filename = substr($filename, 3);
    echo $filename;
    imagedestroy($img_resized);
}