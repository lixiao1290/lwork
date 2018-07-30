<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/2 0002
 * Time: 下午 14:10
 */

namespace minicore\mvc\controller;


use minicore\lib\ControllerBase;
use minicore\lib\View;

/**
 * Class ExceptionController
 * @package minicore\mvc\controller
 */
class ExceptionController extends ControllerBase
{
    /**
     *展示 错误信息
     */
    public function show()
    {
        return View::view();
    }
}