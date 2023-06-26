<?php
if (strlen(session_id()) < 1) session_start();
define("_EXECPERMIT_WNV", true);
header("Content-type: image/jpeg");
$charlist = '023456789abcdefghijkmnopqrstuvwxyz'; 
$chars = 5; $i = 0; while ($i < $chars){
	$string .= substr($charlist, mt_rand(0, strlen($charlist)-1), 1); $i++;
	} 
$_SESSION['tivrbc110cal_captchacode'] = $string;
$rotweim=rand(1,4);
$height = 35; 
$width = 130;
$captcha = imagecreatetruecolor($width, $height);
$bg = imagecolorallocate( $captcha,247, 247, 247);
imagefill( $captcha, 0, 0, $bg ); 
$pixel_color = imagecolorallocate($captcha,92, 92, 92);
for($i=0;$i<90;$i++) {
    imagesetpixel($captcha,rand()%130,rand()%35,$pixel_color);
}
$char=0;
for( $q=0; $q<strlen($string); $q++ ) {
$col = imagecolorallocate($captcha,100, 100, 100); 
$rotwe=rand(-20,20);
$rotwx=rand(20,35);
if($char===0){$vx=8;}else{$vx=$char*27;}
imagettftext($captcha, 26, $rotwe, $vx, 27, $col, 'assets/fonts/monofont.ttf', $string[$q]);
$char++;
 }
$pixelcolor = imagecolorallocate($captcha,255, 255, 255);
for($i=0;$i<500;$i++) {
    imagesetpixel($captcha,rand()%130,rand()%35,$pixelcolor);
}
imagefilter($captcha, IMG_FILTER_GRAYSCALE);
imagejpeg($captcha,NULL,20);
imagedestroy($captcha);
?>