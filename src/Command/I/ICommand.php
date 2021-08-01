<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021-07-29
 * Time: 22:59
 */
namespace wutongshenyuan\qrcode_prettify\Command\I;
interface ICommand{
    public function execute($QR,$option);
}