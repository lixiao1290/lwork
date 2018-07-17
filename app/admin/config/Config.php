<?php


use minicore\lib\MiniRouteManager;

return array(
    'app'=>array('path'),
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
    'defaultRoute'=>'admin/index/index',
    'controllerNamespace' => 'app\controllers',
    'appNamespace' => 'app',

    // 框架核心初始化模式，1不使用closurequeue，2使用。
    'RunMode' => 1,
    // 路由类型，1默认，2注册
    'routType' => 1,
    'ControllerSuffix' => 'Controller',
    'viewSuffix' => 'php',
    'routClass' => minicore\lib\RequestServer::class,
    'routAct' => 'run',
    'actSuffix' => '',
    'actPrefix' => '',
    'defaultModule' => 'main',
    'defaultController' => 'index',
    'defaultAct' => 'index',
    'urlMode' => 1,
    'layout' => array(
        'layout/left'
    ),
    'app'=>[
        'runMode'=>'',
        'runClosure'=>function ($app) {
            echo 'a';
        },
        'runClass'=>['class'=>\minicore\run\RunClass::class,'method'=>'run'],
        'routManager'=>MiniRouteManager::class,
    ],
    'extentions' => [
        \minicore\lib\RequestServer::class=>[
            'urlDelimiter'=>'/',
            'actLevel'=>3
        ],
        minicore\helper\Db::class => array(
            'host' => 'localhost',

            'user' => 'root',

            'pwd' => 'root',

            'db' => 'mini',

            'port' => '3306',

            'prex' => 'min',

            'dsn'
        ),
    ]
);
 
