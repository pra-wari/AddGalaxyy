<?php
if(!$_SESSION){
	session_start();
}
	
	$random = md5(rand());
	$captcha_code = substr($random, 0, 6);
	$_SESSION["captcha_code"] = $captcha_code;
	$target = imagecreatetruecolor(70,30);
	$captcha_background = imagecolorallocate($target, 255, 255, 255);
	imagefill($target,0,0,$captcha_background);
	$captcha_fore_color = imagecolorallocate($target, 0, 0, 0);
	imagestring($target, 8, 5, 5, $captcha_code, $captcha_fore_color);
	header("Content-type: image/jpeg");
	imagejpeg($target);
?>