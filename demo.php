<?php
require_once __DIR__.'/vendor/autoload.php';
use wutongshenyuan\qrcode_prettify\QrcodeOptions;
use wutongshenyuan\qrcode_prettify\Color\RGBA;
use wutongshenyuan\qrcode_prettify\Qrcode;
use wutongshenyuan\qrcode_prettify\Foreground\Foreground;

$opt = new QrcodeOptions();
//$opt->setForegroundColor(new RGBA(0,255,0));
//$opt->setBackgroundColor(new RGBA(255,255,0));
//$opt->setForegroundImg(Foreground::FOREGROUND_IMG_OBLIQUE_STRIPE);
//$opt->setLogo('');
//$opt->setDotRadius(10);
$opt->setSize(81);
$opt->setForegroundColor(new RGBA(44,129,84));
$opt->setLiquidRadius(QrcodeOptions::RADIUS_LEVEL_10);
Qrcode::make('https://www.baidu.com',$opt);
echo time();
