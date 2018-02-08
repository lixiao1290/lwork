<?php
return array(
    
    'db' => array(
        'host' => 'localhost',
        
        'user' => 'root',
        
        'pwd' => 'root',
        
        'db' => 'mini',
        
        'port' => '3306',
        
        'prex' => 'min',
        
        'dsn'
    ),
    
    'appdir',
    
    'actionLevel' => 1,
    
    'controllerLevel' => 0,
    
    'controllerNamespace' => 'app\controllers',
    'appNamespace' => 'app',
    
    // 框架核心初始化模式，1不使用closurequeue，2使用。
    'executeMode' => 1,
    // 路由类型，1默认，2注册
    'routType' => 1,
    'ControllerSuffix' => 'Controller',
    'viewSuffix' => 'php',
    'routClass' => 'minicore\lib\Rout',
    'routAct' => 'run',
    'actSuffix' => '',
    'actPrefix' => '',
    'defaultController' => 'index',
    'defaultAct' => 'index',
    'urlMode' => 1,
    'defaultModule' => 'main',
    'layout' => array(
        'layout/left'
    )
);
