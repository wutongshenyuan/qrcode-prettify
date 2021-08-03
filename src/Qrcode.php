<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2020/2/10
 * Time: 13:04
 */

namespace wutongshenyuan\qrcode_prettify;

use wutongshenyuan\qrcode_prettify\Command\AddLogoCommand;
use wutongshenyuan\qrcode_prettify\Command\ChangeColorCommand;
use wutongshenyuan\qrcode_prettify\Command\ChangeForegroundCommand;
use wutongshenyuan\qrcode_prettify\QrcodeOptions;

class Qrcode
{
    public static function make($str,QrcodeOptions $opt = null)
    {
		$attr = $opt->getOptions();
        require_once "phpqrcode.php";
        $errorCorrectionLevel = 'H';  //容错级别
        $matrixPointSize = 4;// 每个点几个像素
        $margin = 2; // margin的单位是点，换算成像素就是$margin*$matrixPointSize
        if(isset($attr['size']) && $attr['size']){
            $matrixPointSize = $attr['size'];
        }
        ob_start();
        \QRcode::png($str,false,$errorCorrectionLevel,$matrixPointSize,$margin);
        $imgContent = ob_get_contents();
        ob_end_clean();
		
        if(!$attr){
            return base64_encode($imgContent);
        }
		$filepath = self::getFilePath();
		//file_put_contents($filepath,$imgContent);
        $QR = imagecreatefromstring($imgContent);
        $invoker = new Invoker();
		
		// 前景图修改二维码颜色
		if(isset($attr['foreground_img'])){
			if(isset($attr['color'])){
				unset($attr['color']);
			}
			$invoker->setCmd(new ChangeForegroundCommand());
            $QR = $invoker->invoke($QR,['foreground_img'=>$attr['foreground_img']]);
		}
        
        // 修改颜色
        if(isset($attr['color'])){
            $invoker->setCmd(new ChangeColorCommand());
            $QR = $invoker->invoke($QR,['color'=>$attr['color']]);
        }
        // logo 应该放在最后处理
        if (isset($attr['logo']) && $attr['logo']) {
            $invoker->setCmd(new AddLogoCommand());
            $QR = $invoker->invoke($QR,['logo'=>$attr['logo']]);
        }
        imagepng($QR, $filepath);
		imagedestroy($QR);
        //$base64Img = base64_encode(file_get_contents($path));
        //@unlink($path);
        //return $base64Img;
    }
	private static function getFilePath(){
		$baseDir = __DIR__.'/temp/';
        if(!is_dir($baseDir)){
            mkdir($baseDir,0777,true);
        }
        $filename = time()+rand(10000,99999).'.png';
        $filepath = $baseDir.$filename;
		return $filepath;
	}
}