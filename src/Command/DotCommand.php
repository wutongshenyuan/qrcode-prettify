<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021-08-03
 * Time: 16:23
 */

namespace wutongshenyuan\qrcode_prettify\Command;


class DotCommand extends Command
{
    // 圆点效果 须设置大一点的$matrixPointSize否则圆点画不出来
    // 须以二维码的一个点为处理单位
    public function execute($QR, $option)
    {
       // 先生成一个基本图案 然后按点遍历，依次替换
	   $size = $option['size'];
	   // 外面约定dot_radius传入1-10意思是十分之几，所以这里有个*0.1的过程
	   $radius = $size/2*0.1*$option['dot_radius'];
	   $w = $radius*2;
	   // 生成一个点大小的图
	   $img = imagecreatetruecolor($size, $size);
	   $white = imagecolorallocate($img, 255, 255, 255);
	   $black = imagecolorallocate($img, 0, 0, 0);
		// 填充白色背景 
	   imagefill($img, 0, 0, $white);
	   // 四个角画圆弧
	   /*imagearc() 以 cx，cy（图像左上角为 0, 0）为中心
	   在 image 所代表的图像中画一个椭圆弧。
	   w 和 h 分别指定了椭圆的宽度和高度，
	   起始和结束点以 s 和 e 参数以角度指定。
	   0°位于三点钟位置，以顺时针方向绘画。
	    resource $image,int $cx,int $cy,int $w,int $h,int $s,int $e,int $color
	   */
	   // 左上角
	   imagearc($img,$radius,$radius,$w,$w,180,270,$black);
	   // 右上角
	   imagearc($img,$size-$radius,$radius,$w,$w,-90,0,$black);
	   // 右下角
	   imagearc($img,$size-$radius,$size-$radius,$w,$w,0,90,$black);
	   // 左下角
	   imagearc($img,$radius,$size-$radius,$w,$w,90,180,$black);
	   // 中间封闭区域填充黑色
	   $center = ceil($size/2);
	   imagefill($img,$center,$center,$black);
	   // 基本图案生成完毕，下面开始逐点替换
	    /*resource $dst_im,resource $src_im,int $dst_x,int $dst_y,int $src_x,int $src_y,int $src_w,int $src_h,int $pct*/
	   $qrwidth = imagesx($QR);
	   $pointNum = $qrwidth/$size;
	   for($i=0;$i<$pointNum;$i++){
		   $start_x = $size*$i;
		  for($j=0;$j<$pointNum;$j++){
			  $start_y = $size*$j;
			  $color_index = imagecolorat($QR,$start_x,$start_y);
			  $color = imagecolorsforindex($QR, $color_index);
			  // 如果是黑色，则用基本图替换
			  if($color['red']==0 && $color['green']==0 && $color['blue']==0){
				   imagecopymerge($QR,$img,$start_x,$start_y,0,0,$size,$size,100);
			  }
		  }
	   }
	   imagedestroy($img);
       return $QR;
    }
}