<?php

namespace minicore\lib;

use minicore\config\ConfigBase;
use app;
use minicore\config\Configer;

/**
 *
 * @author lixiao
 *
 */
class RequestServer extends Base
{

    /* url参数分隔符 */
    public static $urlDelimiter;

    /* 控制器 在url参数中位置是第几个 */
    public static $actLevel = 3;

    public function __construct()
    {
    }


    /**
     *
     * @param multitype : $rule
     */
    public static function get($url, \Closure $act)
    {
        self::$rule[$url] = $act;
    }

    public static function post($url, \Closure $act)
    {
    }

    public static function getRule($key)
    {
    }

    public static function initGet($array)
    {
        while ($var = array_shift($array)) {
            $_GET[$var] = array_shift($array);
            $_REQUEST[$var] = $_GET[$var];
        }
    }

    /**
     * 生成控制器方法arr。.
     *
     * @param unknown $url
     * @throws \ErrorException
     * @return string[]|mixed[]|string[]|mixed[]|\minicore\lib\the[]
     */
    public static function generatRoute($url)
    {

        $pars = explode('\\', $url);
        $pars = array_filter($pars);
        if(count($pars)<self::$actLevel) {
           $route= Configer::getConfig("defaultRoute"); 
           return self::generatRoute(self::analyzeUrl($route));
        }
        if (strpos($url, '?')) {
            $url = substr($url, 0, strpos($url, '?'));
        }
        if (2 == self::$actLevel) {

            $actArr = array_splice($pars, 0, self::$actLevel);
            self::initGet($pars);
            $act = array_pop($actArr);
            $controller = 'controllers\\' . array_pop($actArr);

            return array(
                'controller' => $controller,
                'act'        => $act
            );
        } else {


            $actArr = array_splice($pars, 0, self::$actLevel);
            if (!empty($pars)) {
                self::initGet($pars);
            }
            $act = array_pop($actArr);
            $controller = array_pop($actArr);
            if (empty($controllerId)) {
                $controllerId = Mini::$app->getConfig('defaultController');
            }

            Mini::$app->setModule(implode('\\', $actArr));
            if (!Mini::$app->getModule()) {
                Mini::$app->setModule(Mini::$app->getConfig('defaultModule'));
            } else {
            }
            $controller = $controller;
            $routeArr = array(
                'module'     => Mini::$app->getModule(),
                'controller' => $controller,
                'act'        => $act
            );

            $routeArr['route'] = implode('/', $routeArr);
            return $routeArr;
        }
    }

    /**
     * 运行程序撒......
     */
    public static function runRout($routeArr)
    {
        if (array_key_exists(static::class, Mini::$app->getConfig('extentions'))) {
            static::miniObjInitStatic(Configer::getConfig('extentions')[static::class]);
        }
        // echo self::$urlDelimiter,'ijiji';
        if (1 == Mini::$app->getConfig('routType')) {
            // if($config=Mini::$app->getConfig('layout')) {
            // foreach ($config as $row) {
            // self::partial($row);
            // }
            // }
            if ('' == $routeArr['controller']) {
                $routeArr['controller'] = Mini::$app->getConfig('defaultController');
            }
            if ($routeArr['act'] == '') {

                $routeArr['act'] = Mini::$app->getConfig('defaultAct');
            }
            if ($routeArr['module']) {
                $controller = Mini::$app->getConfig('appNamespace') . '\\' . $routeArr['module'] . '\\controllers\\' . $routeArr['controller'] . Mini::$app->getConfig('ControllerSuffix');
            } else {
                $controller = Mini::$app->getConfig('appNamespace') . '\\' . $routeArr['controller'] . Mini::$app->getConfig('ControllerSuffix');
            }
//            $controller="";
            Mini::$app->setControllerName($routeArr['controller']);
            Mini::$app->setController($controller);
            $act=Mini::$app->getConfig('actPrefix') . $routeArr['act'] . Mini::$app->getConfig('actSuffix');
            Mini::$app->setAct($act);
            if (class_exists($controller)) {
                $controllerObj = Mini::createObj($controller);
                Mini::$app->setControllerInstance($controllerObj);
                if (method_exists($controllerObj, Mini::$app->getAct())) {
                    call_user_func(array(
                        $controllerObj,
                        Mini::$app->getAct()
                    ));
                    exit;
                } else {
                    header("HTTP/1.1 404 Not Found");
                    header("Status: 404 Not Found");
                    exit();
                }

            } else {
                throw new \Exception("class" . $controller . " not found");
            }
        }
    }

    public static function analyzeUrl($url = null)
    {
        if (empty($url)) {

            if (1 == Mini::$app->getConfig('urlMode')) {
                if (isset($_SERVER['PATH_INFO'])) {
                    return strtr($_SERVER['PATH_INFO'], array(
                        '/' => '\\'
                    ));
                } else {
                    $uri = $_SERVER['REQUEST_URI']; // echo $uri,'<br>';
                    $root = $_SERVER['DOCUMENT_ROOT'];//  echo $root,'<br>';
                    $scriptFileName = dirname($_SERVER['SCRIPT_FILENAME']); // echo 'scrii',$scriptFileName,'<br>';
                    $str = strtr($scriptFileName, array(
                        $root => null
                    ));
                    $rs = strtr($uri, array(
                        $str => null
                    )); // exit;
                    return strtr($rs, array(
                        '/'         => '\\',
                        'index.php' => ''
                    ));
                }
            }
        } else {
            return strtr($url, array(
                '/' => '\\'
            ));
        }
    }

    public static function partial($path)
    {
        $path = self::analyzeUrl($path);
        $routeArr = self::generatController($path);
        if ($routeArr['module']) {
            $Controller = Mini::$app->getConfig('appNamespace') . '\\' . $routeArr['module'] . '\\controllers\\' . $routeArr['controller'] . Mini::$app->getConfig('ControllerSuffix');
        } else {
            $Controller = Mini::$app->getConfig('appNamespace') . '\\' . $routeArr['controller'] . Mini::$app->getConfig('ControllerSuffix');
        }
        if (class_exists($Controller)) {
            $ControllerObj = new $Controller();
            call_user_func(array(
                $ControllerObj,
                $routeArr['act']
            ));
        } else {
            echo(' ');
        }
    }

    public static function callAct($routeArr)
    {
    }
}

