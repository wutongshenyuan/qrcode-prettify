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
        for($i=0;$i<$pointNum;$i++){
            for($j=0;$j<$pointNum;$j++){

            }
        }
        return $QR;
    }
}