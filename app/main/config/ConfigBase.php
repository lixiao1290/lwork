<?php
namespace minicore\config;

use minicore\lib\Base;

class ConfigBase extends Base
{

    private static  $config=array();
    /**
     * @return the $config
     */
    public static function getConfig()
    {
        return ConfigBase::$config;
    }

    /**
     * @param multitype: $config
     */
    public static function setConfig($config)
    {
        ConfigBase::$config = $config;
    }

    public function __construct()
    {}
/* 
    public static $dbHost = 'localhost';

    public static $dbUsr = 'root';

    public static $dbPwd = 'root';

    public static $dbName = 'mini';

    public static $dbPort = '3306';

    public static $dbPrex = 'min';

    public static $dbdsn;

    public static $appdir;

    public static $actionLevel = 1;

    public static $controllerLevel = 0;

    public static $controllerNamespace='app\controllers';
    
    // 框架核心初始化模式，1不使用closurequeue，2使用。
    public static $executeMode = 1;
    // 路由类型，1默认，2注册
    public static $routType=1;
 */}

