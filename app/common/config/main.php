<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
    	// 微信模块
	    'wechat' => [
	        'class' => 'callmez\wechat\Module',
	        'adminId' => 1 // 这里填写管理员ID(拥有wechat最高管理权限), 默认为第一个用户
	    ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    /* 'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'rules' => [
        ],
    ], */
];
