<?php
namespace app\main\controllers;

use minicore\lib\ControllerBase;

class LayoutController extends ControllerBase
{
    public function left()
    {
        $this->assign('menu', array('首页','会员管理'));
        $this->view();
    }
}

