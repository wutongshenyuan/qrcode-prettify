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

class Qrcode
{
    public static function make($str,$attr=[])
    {
        require_once "phpqrcode.php";
        $errorCorrectionLevel = 'H';  //容错级别
        $matrixPointSize = 50;      //生成图片大小
        if(isset($attr['size']) && $attr['size']){
            $matrixPointSize = $attr['size'];
        }
        ob_start();
        \QRcode::png($str,false,$errorCorrectionLevel,$matrixPointSize,2);
        $imgContent = ob_get_contents();
        ob_end_clean();
        if(!$attr){
            return base64_encode($imgContent);
        }
        $QR = imagecreatefromstring($imgContent);
        $invoker = new Invoker();
        $baseDir = __DIR__.'/temp/';
        if(!is_dir($baseDir)){
            mkdir($baseDir,0777,true);
        }
        $filename = time()+rand(10000,99999).'.png';
        $path = $baseDir.$filename;
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
        imagepng($QR, $path);
        $base64Img = base64_encode(file_get_contents($path));
        @unlink($path);
        return $base64Img;
    }
}