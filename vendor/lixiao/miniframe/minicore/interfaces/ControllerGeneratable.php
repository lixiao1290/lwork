<?php
namespace minicore\interfaces;

interface  ControllerGeneratable
{
    
    /* 根据url获取的控制器名 */
    public function getController();
    /*根据url获取的方法名  */
    public function getMethod();
}

?>