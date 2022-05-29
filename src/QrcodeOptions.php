<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021-07-12
 * Time: 14:54
 */

namespace wutongshenyuan\qrcode_prettify;
use wutongshenyuan\qrcode_prettify\Color\RGBA;

class QrcodeOptions
{
    const RADIUS_LEVEL_1 = 1;
    const RADIUS_LEVEL_2 = 2;
    const RADIUS_LEVEL_3 = 3;
    const RADIUS_LEVEL_4 = 4;
    const RADIUS_LEVEL_5 = 5;
    const RADIUS_LEVEL_6 = 6;
    const RADIUS_LEVEL_7 = 7;
    const RADIUS_LEVEL_8 = 8;
    const RADIUS_LEVEL_9 = 9;
    const RADIUS_LEVEL_10 = 10;

    const GRADIEN_DIR_VERTICAL=1;//从上到下渐变
    const GRADIEN_DIR_HORIZONTAL=2;//从左到右渐变
    const GRADIEN_DIR_ELLIPSE=3;//椭圆渐变
    const GRADIEN_DIR_CIRCLE=4;//圆形渐变
    const GRADIEN_DIR_RECTANGLE=5;//矩形渐变
    const GRADIEN_DIR_DIAMOND=6;//菱形渐变

    private $options = [];
    public function setLogo($logoUrl){
        $this->options['logo'] = $logoUrl;
        return $this;
    }

    //matrixPointSize
    public function setSize($size){
        $this->options['size'] = $size;
        return $this;
    }

    // style是一些预设好的效果包括前景背景颜色液态圆点等的组合效果
    // 如果设置了style,又单独设置了其它属性，则会覆盖style的设置
    // 暂未实现
    public function setStyle($style){
        // 暂未实现 后期实现了 约定一些常量供选择
        $this->options['style'] = $style;
        return $this;
    }

    // $foreground 指黑白码中的黑色
    // $background指黑白码中的白色
    // 如果想用渐变色 那么就传数组，传多个颜色，
    // 实现原理是用渐变色先创建一张图，再把二维码前景或背景变透明，然后与渐变图合成
	// 
    public function setForegroundColor(RGBA $foreground_color){
        $this->options['color']['foreground_color'] = $foreground_color;
        return $this;
    }
	public function setBackgroundColor(RGBA $background_color){
		$this->options['color']['background_color'] = $background_color;
        return $this;
	}
	public function setGradientForegroundColor(RGBA $begin_color,RGBA $end_color,$direction){
        $this->options['color']['foreground_color'] = [
            'begin_color'=>$begin_color,
            'end_color'=>$end_color,
            'direction'=>$direction
        ];
        return $this;
    }
    // 修改背景色需求少，先不实现了
//    public function setGradientBackgroundColor(RGBA $begin_color,RGBA $end_color,$direction){
//        $this->options['color']['background_color'] = [
//            'begin_color'=>$begin_color,
//            'end_color'=>$end_color,
//            'direction'=>$direction
//        ];
//        return $this;
//    }
	// 此选项会导致 foreground_color、 background_color 失效
	// 使用gif动图做前景图片会更炫
    public function setForegroundImg($foreground){
        $this->options['foreground_img'] = $foreground;
        return $this;
    }
	// 此选项会导致 background_color 失效，不过暂时未实现
    public function setBackgroundImg($background){
        $this->options['background_img'] = $background;
        return $this;
    }
    // 设置圆点化半径 此设置与setLiquidRadius互斥
    // 半径值分十个等级 请取RADIUS_LEVEL_x常量
    public function setDotRadius($radius){
        if(isset($this->options['liquid_radius'])){
            unset($this->options['liquid_radius']);
        }
        $this->options['dot_radius'] = $radius;
        return $this;
    }
    // 设置液态化半径 此设置与setDotRadius互斥
    // 半径值分十个等级 请取RADIUS_LEVEL_x常量
    public function setLiquidRadius($radius){
        if(isset($this->options['dot_radius'])){
            unset($this->options['dot_radius']);
        }
        $this->options['liquid_radius'] = $radius;
        return $this;
    }
    // 添加文案
    public function setCopywriting($content){
        $this->options['copywriting'] = $content;
        return $this;
    }
    // 文案字体颜色
    public function setCopywritingColor($color){
        $this->options['copywriting_color'] = $color;
        return $this;
    }
    // 文案的字体
    public function setCopywritingFont($font){
        $this->options['copywriting_font'] = $font;
        return $this;
    }
    // 暂未实现 后期实现了会约定一些常量供选择
    public function setCodeEyeStyle($code_eye){
        $this->options['code_eye_style'] = $code_eye;
        return $this;
    }
    // 不要用前景（图或颜色）填充码眼，此项为true的时候
    // setCodeEyeOuterBorderColor与setCodeEyeInnerBorderColor才会生效
    public function setDoNotFillCodeEyeWithForeground($bool){
        $this->options['do_not_fill_code_eye_with_foreground']=$bool;
        return $this;
    }
    // 码眼外框颜色
    public function setCodeEyeOuterBorderColor($color){
        $this->options['code_eye_outer_border_color'] = $color;
        return $this;
    }
    // 码眼内框颜色
    public function setCodeEyeInnerBorderColor($color){
        $this->options['code_eye_inner_border_color'] = $color;
        return $this;
    }
    public function getOptions(){
        return $this->options;
    }
}