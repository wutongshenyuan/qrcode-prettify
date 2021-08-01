<?php
namespace wutongshenyuan\qrcode_prettify\Foreground;
class Foreground{
	const FOREGROUND_IMG_BEAUTY=1;
	const FOREGROUND_IMG_BLACK_TRIANGLE=2;
	const FOREGROUND_IMG_BROWN=3;
	const FOREGROUND_IMG_COLOR_BRICK=4;
	const FOREGROUND_IMG_COLOR_BUBBLE=5;
	const FOREGROUND_IMG_COLOR_RIVERS=6;
	const FOREGROUND_IMG_CROWN=7;
	const FOREGROUND_IMG_EYE=8;
	const FOREGROUND_IMG_HOURGLASS=9;
	const FOREGROUND_IMG_OBLIQUE_STRIPE=10;
	const FOREGROUND_IMG_OVAL=11;
	const FOREGROUND_IMG_PINK_BLUE=12;
	const FOREGROUND_IMG_PURPLE_BLUE=13;
	const FOREGROUND_IMG_PURPLE_ORANGE=14;
	const FOREGROUND_IMG_JIGSAW=15;
	const FOREGROUND_IMG_RADIATE=16;
	const FOREGROUND_IMG_RED_BRICK=17;
	const FOREGROUND_IMG_RED_SUN=18;
	const FOREGROUND_IMG_RGB=19;
	const FOREGROUND_IMG_ROTATE_RADIATE=20;
	const FOREGROUND_IMG_STAR=21;
	const FOREGROUND_IMG_VERTICAL_STRIPE=22;
	
	public static function getForegroundImgPath($index){
		$baseDir = __DIR__.'/ForegroundImages/';
		$paths = [
			self::FOREGROUND_IMG_BEAUTY=>$baseDir.'beauty.jpg',
			self::FOREGROUND_IMG_BLACK_TRIANGLE=>$baseDir.'black_triangle.jpg',
			self::FOREGROUND_IMG_BROWN=>$baseDir.'brown.jpg',
			self::FOREGROUND_IMG_COLOR_BRICK=>$baseDir.'color_brick.jpg',
			self::FOREGROUND_IMG_COLOR_BUBBLE=>$baseDir.'color_bubble.jpg',
			self::FOREGROUND_IMG_COLOR_RIVERS=>$baseDir.'color_rivers.jpg',
			self::FOREGROUND_IMG_CROWN=>$baseDir.'crown.jpg',
			self::FOREGROUND_IMG_EYE=>$baseDir.'eye.jpg',
			self::FOREGROUND_IMG_HOURGLASS=>$baseDir.'hourglass.jpg',
			self::FOREGROUND_IMG_OBLIQUE_STRIPE=>$baseDir.'oblique_stripe.jpg',
			self::FOREGROUND_IMG_OVAL=>$baseDir.'oval.jpg',
			self::FOREGROUND_IMG_PINK_BLUE=>$baseDir.'pink_blue.jpg',
			self::FOREGROUND_IMG_PURPLE_BLUE=>$baseDir.'purple_blue.jpg',
			self::FOREGROUND_IMG_PURPLE_ORANGE=>$baseDir.'purple_orange.jpg',
			self::FOREGROUND_IMG_JIGSAW=>$baseDir.'jigsaw.png',
			self::FOREGROUND_IMG_RADIATE=>$baseDir.'radiate.jpg',
			self::FOREGROUND_IMG_RED_BRICK=>$baseDir.'red_brick.jpg',
			self::FOREGROUND_IMG_RED_SUN=>$baseDir.'red_sun.jpg',
			self::FOREGROUND_IMG_RGB=>$baseDir.'rgb.jpg',
			self::FOREGROUND_IMG_ROTATE_RADIATE=>$baseDir.'rotate_radiate.png',
			self::FOREGROUND_IMG_STAR=>$baseDir.'star.jpg',
			self::FOREGROUND_IMG_VERTICAL_STRIPE=>$baseDir.'vertical_stripe.jpg'
		];
		if(isset($paths[$index])){
			return $paths[$index];
		}else{
			return '';
		}
	}
}