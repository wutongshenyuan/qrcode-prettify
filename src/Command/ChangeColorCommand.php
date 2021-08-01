<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021-07-30
 * Time: 13:03
 */

namespace wutongshenyuan\qrcode_prettify\Command;

class ChangeColorCommand extends Command
{
    public function execute($QR, $option)
    {
		$foreground_color = isset($option['color']['foreground_color'])?$option['color']['foreground_color']:'';
		$background_color = isset($option['color']['background_color'])?$option['color']['background_color']:'';
		if(!$foreground_color && !$background_color){
			return $QR;
		}
		// 我们用phpqrcode得到的二维码，默认为黑白的
		// 在gd中，会把图像中的每一种颜色编号，当我们得到某种颜色的索引后，
		// 可以把这个颜色替换成其他颜色，而不必遍历每一个像素去修改
		// 修改前景色 
		if($foreground_color){
			// imagecolorexact用来获取指定颜色的索引值
			$black_index = imagecolorexact($QR,0,0,0);
			if($black_index){
				imagecolorset(
				$QR,
				$black_index,
				$foreground_color->getR(),
				$foreground_color->getG(),
				$foreground_color->getB()
				);
			}
		}
		// 修改背景色
		if($background_color){
			// 背景色的处理与前景色不同，
			// phpqrcode生成二维码原理是：
			// 创建一张图片，填充白色背景，
			// 有数据的地方画上黑色像素，
			// 背景色是填充色,imagecolorset处理不了，
			// 尝试用imagefill处理过，但是一些封闭区域还是处理不了，
			// 需要再逐像素检测，效率太低
			/*$color = imagecolorallocate(
			$QR, 
			$background_color->getR(), 
			$background_color->getG(), 
			$background_color->getB()
			);
			imagefill($QR, 0, 0, $color);*/
			// 转为真彩图像
			if(!imageistruecolor($QR)){
				$res = imagepalettetotruecolor($QR);
				if(!$res){
					return $QR;
				}
			}
			//将白色背景转为透明
			imagecolortransparent(
			$QR, 
			imagecolorallocate(
			$QR, 
			255, 
			255, 
			255
			));
			$w = imagesx($QR);
			$h = imagesy($QR);
			// 创建一张新真彩图
			$resImage = imagecreatetruecolor ($w, $h);
			// 用新背景颜色填充新图
			imagefill(
			$resImage, 
			0, 
			0, 
			imagecolorallocate(
			$resImage, 
			$background_color->getR(), 
			$background_color->getG(),
			$background_color->getB()
			));
			imagecopymerge($resImage,$QR,0,0,0,0,$w,$h,100);
			imagedestroy($QR);
			$QR=$resImage;
		}
		return $QR;
    }
}