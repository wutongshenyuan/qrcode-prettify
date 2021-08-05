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
    const LEFT_TOP = 1;
    const RIGHT_TOP = 2;
    const RIGHT_BOTTOM = 4;
    const LEFT_BOTTOM = 8;
	private $baseImgs=[];
	private $option = [];
    // 液化效果
    // 实现思路，可通过size，margin参数定位二维码的每一个点
    // 遍历每一个点（注意不是像素）根据其黑白交替情况，用带圆角的图片替换
    // 把二维码的每一个点看成一张图片，那么液化状态下的二维码共有十种基本图片组成
    // 无圆角图片（就是正常的正方形）一个圆角图片 两个圆角图片 三个圆角图片 四个圆角图片
    // 以上五中基本图形分黑白两种颜色，就是十种，这还忽略了图片的方向
    public function execute($QR, $option)
    {
        $this->option = $option;
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
				echo $matrix[$i][$j]." ";
            }
			echo "\r\n";
        }
		// 通过计算矩阵中某个点的相邻点情况，决定其液化后用什么图案代替
        $baseNum=0;
        for($i=0;$i<$pointNum;$i++){
            $start_y = $size*$i;
            for($j=0;$j<$pointNum;$j++){
                $start_x = $size*$j;
                $baseImg = $this->getBaseImg($matrix,$i,$j,$margin,$pointNum);
                if($baseImg){
                    $baseNum++;
                    imagecopymerge($QR,$baseImg,$start_x,$start_y,0,0,$size,$size,100);
                    if($baseNum==2){
                        echo $i.'--'.$j."\r\n";
                        break 2;
                    }
                }
            }
        }
        // 释放资源
        if($this->baseImgs){
            foreach ($this->baseImgs as $k=>$v){
                foreach ($v as $kk=>$vv){
                    imagedestroy($vv);
                }
            }
        }
        return $QR;
    }
    private function getBaseImg($matrix,$row,$col,$margin,$pointNum){
        $x = $col;
        $y = $row;
        //把图片圆角的位置编号,
        //每两个相邻边与当前色块不一样颜色的，
        //该角就需要圆角处理
        // 1-----2
        // |     |
        // 8-----4
        // 判断二维码三个角的定位区域不处理 ，或者也可以分块遍历
        $ignorePointNum = $margin+8;
        $left = $ignorePointNum-1;// 从0开始所以需要减1
        $right = $pointNum-$ignorePointNum-1;
        $top = $ignorePointNum-1;
        $bottom = $pointNum-$ignorePointNum-1;

        if($x<=$left&&$y<=$top){
            return false;// 不替换
        }
        if($x>=$right&&$y<=$top){
            return false;// 不替换
        }
        if($x<=$left&&$y>=$bottom){
            return false;// 不替换
        }
        // 忽略margin
        if($x<=($margin-1)||$x>=($pointNum-$margin) || $y<=($margin-1) || $y>=($pointNum-$margin)){
            return false;// 不替换
        }
        // 白色收缩方案 两条边对应颜色不一致则收缩
        // 黑色收缩方案 两条边对应颜色不一致，顶点对应颜色也不一致则收缩
        // x表示列 y表示行
        $curPoint = $matrix[$y][$x];
        $top = isset($matrix[$y][$x-1])?$matrix[$y][$x-1]:(int)!$curPoint;
        $right = isset($matrix[$y+1][$x])?$matrix[$y+1][$x]:(int)!$curPoint;
        $bottom = isset($matrix[$y][$x+1])?$matrix[$y][$x+1]:(int)!$curPoint;
        $left = isset($matrix[$y-1][$x])?$matrix[$y-1][$x]:(int)!$curPoint;
        $leftTop = isset($matrix[$y-1][$x-1])?$matrix[$y-1][$x-1]:(int)!$curPoint;
        $rightTop = isset($matrix[$y+1][$x-1])?$matrix[$y+1][$x-1]:(int)!$curPoint;
        $rightBottom = isset($matrix[$y+1][$x+1])?$matrix[$y+1][$x+1]:(int)!$curPoint;
        $leftBottom = isset($matrix[$y-1][$x+1])?$matrix[$y-1][$x+1]:(int)!$curPoint;
        if($y==2 && $x==14){
            echo '$curPoint:'.$curPoint."\r\n";
            echo '$top:'.$top."\r\n";
            echo '$right:'.$right."\r\n";
            echo '$bottom:'.$bottom."\r\n";
            echo '$left:'.$left."\r\n";
            echo '$leftTop:'.$leftTop."\r\n";
            echo '$rightTop:'.$rightTop."\r\n";
            echo '$rightBottom:'.$rightBottom."\r\n";
            echo '$leftBottom:'.$leftBottom."\r\n";
        }
        $baseImgNum = 0;
        if($curPoint==0){//白色收缩方案
            if($left==$top && $left!=$curPoint){
                $baseImgNum +=self::LEFT_TOP;
            }
            if($top==$right && $top!=$curPoint){
                $baseImgNum +=self::RIGHT_TOP;
            }
            if($right==$bottom && $right!=$curPoint){
                $baseImgNum +=self::RIGHT_BOTTOM;
            }
            if($bottom==$left && $bottom!=$curPoint){
                $baseImgNum +=self::LEFT_BOTTOM;
            }
        }else{// 黑色收缩方案
            if($left==$top && $left==$leftTop && $left!=$curPoint){
                $baseImgNum +=self::LEFT_TOP;
            }
            if($top==$right && $top==$rightTop  && $top!=$curPoint){
                $baseImgNum +=self::RIGHT_TOP;
            }
            if($right==$bottom && $right==$rightBottom && $right!=$curPoint){
                $baseImgNum +=self::RIGHT_BOTTOM;
            }
            if($bottom==$left && $bottom==$leftBottom && $bottom!=$curPoint){
                $baseImgNum +=self::LEFT_BOTTOM;
            }
        }

        //echo $baseImgNum."\t";
        if(!$baseImgNum){
            return false;
        }
        return $this->makeBaseImg($curPoint,$baseImgNum);
    }
	private function makeBaseImg($curPointColor,$baseImgNum){
        if(isset($this->baseImgs[$curPointColor]) && isset($this->baseImgs[$curPointColor][$baseImgNum])){
            return $this->baseImgs[$curPointColor][$baseImgNum];
        }
        $size = $this->option['size'];
        // 外面约定dot_radius传入1-10意思是十分之几，所以这里有个*0.1的过程
        $radius = $size/2*0.1*$this->option['liquid_radius'];
        $w = $radius*2;
        $baseImg = imagecreate($size,$size);
        if($curPointColor==0){
            $foregroundColor = imagecolorallocate($baseImg,255,255,255);
            $backgroundColor = imagecolorallocate($baseImg,0,0,0);
        }else{
            $foregroundColor = imagecolorallocate($baseImg,0,0,0);
            $backgroundColor = imagecolorallocate($baseImg,255,255,255);
        }
        imagefill($baseImg,0,0,$backgroundColor);

        if($baseImgNum & self::LEFT_TOP){
            // 左上角
            imagearc($baseImg,$radius,$radius,$w,$w,180,270,$foregroundColor);
        }
        if($baseImgNum & self::RIGHT_TOP){
            // 右上角
            imagearc($baseImg,$size-$radius,$radius,$w,$w,-90,0,$foregroundColor);
        }
        if($baseImgNum & self::RIGHT_BOTTOM){
            // 右下角
            imagearc($baseImg,$size-$radius,$size-$radius,$w,$w,0,90,$foregroundColor);
        }
        if($baseImgNum & self::LEFT_BOTTOM){
            // 左下角
            imagearc($baseImg,$radius,$size-$radius,$w,$w,90,180,$foregroundColor);
        }
        $center = ceil($size/2);
        imagefill($baseImg,$center,$center,$foregroundColor);
        $this->baseImgs[$curPointColor][$baseImgNum] = $baseImg;
        imagepng($baseImg,__DIR__.'/../temp/'.time().rand(1000,9999).'.png');
        return $baseImg;
	}
}