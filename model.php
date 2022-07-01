<?php
session_start();
if (empty($_SESSION['player'])) {exit();}}
if (empty($_SESSION['player'])) {exit();}}

$resize_with = 15;

$img1_path = "/img/game/captcha/".$_SESSION['captcha_1'].".png";
$img2_path = "/img/game/captcha/".$_SESSION['captcha_2'].".png";
$img3_path = "/img/game/captcha/".$_SESSION['captcha_3'].".png";
$img4_path = "/img/game/captcha/texto.png";

list($img1_width, $img1_height) = getimagesize($img1_path);
list($img2_width, $img2_height) = getimagesize($img2_path);
list($img3_width, $img3_height) = getimagesize($img3_path);
list($img4_width, $img4_height) = getimagesize($img4_path);

$img1_width_resized = $img1_width + $resize_with;
$img1_height_resized = $img1_height + $resize_with;
$img2_width_resized = $img2_width + $resize_with;
$img2_height_resized = $img2_height + $resize_with;
$img3_width_resized = $img3_width + $resize_with;
$img3_height_resized = $img3_height + $resize_with;
$img4_width_resized = $img4_width + $resize_with * 3;
$img4_height_resized = $img4_height + $resize_with;

$merged_width  = $img1_width_resized + $img2_width_resized + $img3_width_resized;
//get highest
$merged_height = $img1_height_resized > $img2_height_resized ? $img1_height_resized : $img2_height_resized;

$merged_image = imagecreatetruecolor($merged_width, $merged_height);

imagealphablending($merged_image, false);
imagesavealpha($merged_image, true);

$img1 = imagecreatefrompng($img1_path);
$img2 = imagecreatefrompng($img2_path);
$img3 = imagecreatefrompng($img3_path);
$img4 = imagecreatefrompng($img4_path);

imagecopyresized($merged_image, $img1, 0, 0, 0, 0, $img1_width_resized, $img1_height_resized, $img1_width, $img1_height);
//place at right side of $img1
imagecopyresized($merged_image, $img2, $img1_width_resized, 0, 0, 0, $img2_width_resized, $img2_height_resized, $img2_width, $img2_height);
imagecopyresized($merged_image, $img3, ($img1_width_resized + $img2_width_resized), 0, 0, 0, $img3_width_resized, $img3_height_resized, $img3_width, $img3_height);
imagefilter($merged_image, IMG_FILTER_GRAYSCALE);
imagealphablending($merged_image,true);

imagecopyresized($merged_image, $img4,0, 0, 0, 0, $img4_width_resized, $img4_height_resized, $img4_width, $img4_height);

header('Content-Type: image/png');
imagepng($merged_image);


//release memory
imagedestroy($merged_image);

?>
