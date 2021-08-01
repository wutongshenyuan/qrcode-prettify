<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021-07-29
 * Time: 23:03
 */

namespace wutongshenyuan\qrcode_prettify\Command;


class AddLogoCommand extends Command
{
    public function execute($QR,$option)
    {
        $logoContent = file_get_contents($option['logo']);
        if(!$logoContent){
            return $QR;
        }
        $logo = imagecreatefromstring($logoContent);
        $QR_width = imagesx($QR);//二维码图片宽度
        //$QR_height = imagesy($QR);//二维码图片高度
        $logo_width = imagesx($logo);//logo图片宽度
        $logo_height = imagesy($logo);//logo图片高度
        $logo_qr_width = $QR_width / 5;
        $scale = $logo_width/$logo_qr_width;
        $logo_qr_height = $logo_height/$scale;
        $from_width = ($QR_width - $logo_qr_width) / 2;
        //重新组合图片并调整大小
        imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
            $logo_qr_height, $logo_width, $logo_height);
        imagedestroy($logo);
        return $QR;
    }
}