<?php
require_once __DIR__.'/vendor/autoload.php';
use wutongshenyuan\qrcode_prettify\QrcodeOptions;
use wutongshenyuan\qrcode_prettify\Color\RGBA;
use wutongshenyuan\qrcode_prettify\Qrcode;
use wutongshenyuan\qrcode_prettify\Foreground\Foreground;

$im = imagecreate(100, 100);
$white = imagecolorallocate($im, 255, 255, 255);
$black = imagecolorallocate($im, 0, 0, 0);
imagefill($im, 0, 0, $white);

imagefilledellipse(
    $im,
    50,
    50,
    50,
    50,
    $black
);
imagepng($im, __DIR__.'/src/temp/tuoyuan.png');
imagedestroy($im);
exit;
$opt = new QrcodeOptions();
$opt->setForegroundColor(new RGBA(0,255,0));
$opt->setBackgroundColor(new RGBA(255,255,0));
$opt->setForegroundImg(Foreground::FOREGROUND_IMG_BEAUTY);
//$opt->setLogo('');
Qrcode::make('https://www.baidu.com',$opt);
echo time();
