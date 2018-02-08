<?php
namespace minicore\run;

use minicore\lib\MiniRouteManager;
use minicore\lib\RequestServer;
use minicore\lib\RunClassAbstract;

class RunClass extends RunClassAbstract
{

    public static function run()
    {
        if (true === (new MiniRouteManager(@$_SESSION['miniroute.route']))->valid()) {
            RequestServer::runRout($_SESSION['miniroute']);
        } else {
            //RequestServer::runRout($_SESSION['miniroute']);
        }
    }
    public function __construct()
    {
        RequestServer::miniObjInitStatic();
        RequestServer::miniObjInitStatic();
        $path = RequestServer::analyzeUrl();
        $routArr = RequestServer::generatRoute($path);
        $_SESSION['miniroute'] = $routArr;
//        var_dump('<pre>',$_SESSION,Configer::getConfig('app.runClass'));

    }
}

