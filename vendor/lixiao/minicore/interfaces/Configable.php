<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/20 0020
 * Time: 下午 16:51
 */

namespace minicore\interfaces;


interface Configable
{
    public   function getConfigs();
    public   function getConfigByName($name);
    public   function getConfigByPatterm($patterm = null);
    public   function setConfig($config, $name);

}