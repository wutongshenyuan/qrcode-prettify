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
        // 也可以按二维码的一个点为单位处理

        return $QR;
    }
}