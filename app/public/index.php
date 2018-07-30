<?php
require '../../vendor/autoload.php';
define("INDEX_DIR",dirname(__FILE__));
$config=require dirname(dirname(__FILE__)).'/admin/config/Config.php';
$config['mini']['params']=require dirname(dirname(__FILE__)).'/admin/config/params.php';
$configurator=new \minicore\lib\Configurator($config);

(new \minicore\lib\MiniApp($configurator))->run();

/*$application = \minicore\lib\Mini::createObj(MiniApp::class,array('config'=>$config));
$application->run();*/


//$db::debug() ;
 