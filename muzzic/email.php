<?php
header ("Content-type: image/png");
$textToConvert = base64_decode($_GET['token']);
$font   = 5;
$width  = ImageFontWidth($font) * strlen($textToConvert);
$height = ImageFontHeight($font);
$im = @imagecreate ($width,$height);
$background_color = imagecolorallocate ($im, 255, 255, 255); //this means it's white bg
$text_color = imagecolorallocate ($im, 0, 0,0);//and of course black text
imagestring ($im, $font, 0, 0,  $textToConvert, $text_color);
imagepng ($im);
?>