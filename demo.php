<?php
require_once __DIR__.'/vendor/autoload.php';
use wutongshenyuan\qrcode_prettify\QrcodeOptions;
use wutongshenyuan\qrcode_prettify\Color\RGBA;
use wutongshenyuan\qrcode_prettify\Qrcode;
use wutongshenyuan\qrcode_prettify\Foreground\Foreground;
ini_set('memory_limit','1024M');

//$opt = new QrcodeOptions();
//$opt->setForegroundColor(new RGBA(0,255,0));
//$opt->setBackgroundColor(new RGBA(255,255,0));
//$opt->setForegroundImg(Foreground::FOREGROUND_IMG_OBLIQUE_STRIPE);
//$opt->setLogo('');
//$opt->setDotRadius(10);
//$opt->setSize(81);
//$opt->setForegroundColor(new RGBA(44,129,84));
//$opt->setLiquidRadius(QrcodeOptions::RADIUS_LEVEL_10);
//Qrcode::make('https://www.baidu.com',$opt);

//渐变色
$opt = new QrcodeOptions();
$opt->setSize(81);
//$opt->setGradientForegroundColor(new RGBA(247, 17, 5,0),new RGBA(3, 142, 234,0),QrcodeOptions::GRADIEN_DIR_VERTICAL);//水平渐变
//$opt->setGradientForegroundColor(new RGBA(247, 17, 5,0),new RGBA(3, 142, 234,0),QrcodeOptions::GRADIEN_DIR_HORIZONTAL);// 垂直渐变
//$opt->setGradientForegroundColor(new RGBA(247, 17, 5,0),new RGBA(3, 142, 234,0),QrcodeOptions::GRADIEN_DIR_DIAGONAL);//对角线渐变
$res = Qrcode::make('https://www.baidu.com',$opt);
