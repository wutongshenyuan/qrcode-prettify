<?php
namespace wutongshenyuan\qrcode_prettify\Command;
use wutongshenyuan\qrcode_prettify\Foreground\Foreground;
class ChangeForegroundCommand extends Command{
	public function execute($QR,$option){
		if(is_int($option['foreground_img'])){
			$foreground_img_path = Foreground::getForegroundImgPath($option['foreground_img']);
			$foregroundContent=file_get_contents($foreground_img_path);
		}else{
			$foregroundContent = file_get_contents($option['foreground_img']);
		}
		if(!$foregroundContent){
			return $QR;
		}
		// 转为真彩图像
		if(!imageistruecolor($QR)){
			$res = imagepalettetotruecolor($QR);
			if(!$res){
				return $QR;
			}
		}
		//将二维码中黑色转为透明
		imagecolortransparent(
		$QR, 
		imagecolorallocate(
		$QR, 
		0, 
		0, 
		0
		));
		$w = imagesx($QR);
		$h = imagesy($QR);
		// 创建一张新真彩图
		$resImage = imagecreatetruecolor ($w, $h);
		// 创建前景图
		$foreground = imagecreatefromstring($foregroundContent);
		$fw = imagesx($foreground);
		$fh = imagesy($foreground);
		
		// 重采样是为了调整$foreground大小与$QR保持一致
		imagecopyresampled(
		$resImage,
		$foreground,
		0,
		0,
		0,
		0,
		$w,
		$h,
		$fw,
		$fh
		);
		imagecopymerge($resImage,$QR,0,0,0,0,$w,$h,100);
		imagedestroy($QR);
		imagedestroy($foreground);
		$QR=$resImage;
		return $QR;
	}
	
}