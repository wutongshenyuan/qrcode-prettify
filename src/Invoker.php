<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021-07-30
 * Time: 8:09
 */

namespace wutongshenyuan\qrcode_prettify;


use wutongshenyuan\qrcode_prettify\Command\I\ICommand;

class Invoker
{
    private $cmd;
    public function setCmd(ICommand $cmd){
        $this->cmd = $cmd;
    }
    public function invoke($gd,$option){
        return $this->cmd->execute($gd,$option);
    }
}