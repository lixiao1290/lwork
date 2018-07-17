<?php

require '../../vendor/autoload.php';
define("INDEX_DIR",dirname(__FILE__));
$config=require dirname(dirname(__FILE__)).'/admin/config/Config.php';
$config['params']=require dirname(dirname(__FILE__)).'/admin/config/params.php';
(new \minicore\lib\MiniApp($config))->run();

/*$application = \minicore\lib\Mini::createObj(MiniApp::class,array('config'=>$config));
$application->run();*/


//$db::debug() ;
 