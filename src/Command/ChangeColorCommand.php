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
		// 修改前景色  黑白码中的黑色
		if($foreground_color){
		    // 渐变色
		    if(is_array($foreground_color)){
                if(isset($foreground_color['begin_color'])
                    && isset($foreground_color['end_color'])
                    && isset($foreground_color['direction'])){
                    $fun = "gradien".ucfirst($foreground_color['direction']);
                    if(method_exists($this,$fun)){
                        $this->{$fun};
                    }
                }
            }else{
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

		}
		// 修改背景色  黑白码中的白色
		if($background_color){
		    // 渐变色
		    if(is_array($background_color)){

            }else{
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
            }

		return $QR;
    }
    private function gradienVertical($color,$img_height){
        $img_width = $img_height;
        $begin_color = $color['begin_color'];
        $end_color = $color['end_color'];
        // 颜色变化步长取相反数
        $rStep = 0-($begin_color->getR()-$end_color->getR())/$img_height;
        $gStep = 0-($begin_color->getG()-$end_color->getG())/$img_height;
        $bStep = 0-($begin_color->getB()-$end_color->getB())/$img_height;
        // 创建一张新真彩图
        $resImage = imagecreatetruecolor ($img_height, $img_height);
        for($i=1;$i<=$img_height;$i++){
            $fillcolor = imagecolorallocate(
                $resImage,
                $this->getColor($begin_color->getR(),$i,$rStep),
                $this->getColor($begin_color->getG(),$i,$gStep),
                $this->getColor($begin_color->getB(),$i,$bStep)
            );
            $x1 = 0;$y1 = $i-1;$x2 = $img_width;$y = $i+1;
            imagefilledrectangle($x1,$y1,$x2,$y,$fillcolor);
        }
        imagepng($resImage,__DIR__."/temp.png");
        exit;
    }
    private function getColor($begin,$round,$step){
        // 四舍五入
        return round($begin+($round-1)*$step);
    }

}