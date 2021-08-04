<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021-08-03
 * Time: 16:24
 */

namespace wutongshenyuan\qrcode_prettify\Command;


class LiquidCommand extends Command
{
	private $baseImgs=[];
    // 液化效果
    // 实现思路，可通过size，margin参数定位二维码的每一个点
    // 遍历每一个点（注意不是像素）根据其黑白交替情况，用带圆角的图片替换
    // 把二维码的每一个点看成一张图片，那么液化状态下的二维码共有十种基本图片组成
    // 无圆角图片（就是正常的正方形）一个圆角图片 两个圆角图片 三个圆角图片 四个圆角图片
    // 以上五中基本图形分黑白两种颜色，就是十种，这还忽略了图片的方向
    public function execute($QR, $option)
    {
        $size = $option['size'];
        $margin = $option['margin'];
        $qrWidth = imagesx($QR);
        $pointNum = $qrWidth/$size;
        $matrix = [];
		// 将图片的颜色转为二维数字矩阵存在$matrix中
		// 类似这样的,当然实际的矩阵，肯定比这个大
		/*
0 0 0 0 0 0 0 0 0 0 0 0 0 
0 0 0 0 0 0 0 0 0 0 0 0 0 
0 0 1 1 1 1 1 1 1 0 1 0 0 
0 0 1 0 0 0 0 0 1 0 0 0 1 
0 0 1 0 1 1 1 0 1 0 0 0 1 
0 0 1 0 1 1 1 0 1 0 1 1 0 
0 0 1 0 1 1 1 0 1 0 0 1 1 
0 0 1 0 0 0 0 0 1 0 0 0 0 
0 0 1 1 1 1 1 1 1 0 1 0 1 
0 0 0 0 0 0 0 0 0 0 0 0 0 
0 0 0 0 1 0 1 1 1 0 1 1 0 
0 0 1 1 0 1 1 1 0 0 0 1 1 
		*/
        for($i=0;$i<$pointNum;$i++){
			$start_y = $size*$i;
            for($j=0;$j<$pointNum;$j++){
				$start_x = $size*$j;
				$color = imagecolorsforindex($QR,imagecolorat($QR,$start_x,$start_y));
				if($color['red']==255){
					$matrix[$i][$j]=0;
				}else{
					$matrix[$i][$j]=1;
				}
				//echo $matrix[$i][$j]." ";
            }
			//echo "\r\n";
        }
		// 通过计算矩阵中某个点的相邻点情况，决定其液化后用什么图案代替

        return $QR;
    }
}