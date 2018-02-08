<?php

namespace minicore\lib;

use minicore\config\ConfigBase;
use minicore\mvc\controller\ExceptionController;
use minicore\traits\SingleInstance;
use minicore\helper\Db;
use Composer\Autoload\ComposerStaticInit344e82d8c2bfce44cf961e58b48d128c;
use minicore\helper\DbContainer;
use minicore\interfaces\MiniInterface;
use minicore\config\Configer;
use app\run\RunClass;

/**
 *
 * @author Administrator
 * @property
 *
 */
class MiniApp extends MiniBase
{

    /**
     * @var string $controller
     */
    private $controller;

    /**
     * @var string $act
     */
    private $act;

    /**
     * @var string $baseDir
     */
    private $baseDir;


    /**
     * @var \miniCore\lib\ControllerBase $controllerStance
     */
    private $controllerInstance;

    /**
     * @return ControllerBase $controllerInstance
     */
    public function getControllerInstance()
    {
        return $this->controllerInstance;
    }

    /**
     * @param ControllerBase $controllerInstance
     */
    public function setControllerInstance($controllerInstance)
    {
        $this->controllerInstance= $controllerInstance;
    }

    /**
     * @var string $viewPath
     */
    private $viewPath;

    private $module;

    private $component;
    /**
     * @var string $controllerName
     */
    private $controllerName;

    public static $params;

    /**
     * @return the $controllerName
     */
    public function getControllerName()
    {
        return $this->controllerName;
    }

    /**
     * @param field_type $controllerName
     */
    public function setControllerName($controllerName)
    {
        $this->controllerName = $controllerName;
    }

    /**
     *
     * @return the $params
     */
    public static function getParams($key)
    {
        return MiniApp::$params[$key];
    }

    /**
     *
     * @param field_type $params
     */
    public static function setParams($params)
    {
        MiniApp::$params = $params;
    }

    public function __get($name = NULL)
    {
        var_dump($name);
        if (array_key_exists($name, $this->component)) {
            return $this->component[$name];
        }
    }

    public function __set($name, $component)
    {
        $this->component[$name] = $component;
    }

    /**
     *
     * @return the $module
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     *
     * @param field_type $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

    /**
     *
     * @return the $viewPath
     */
    public function getViewPath()
    {
        return $this->viewPath;
    }

    /**
     *
     * @param field_type $viewPath
     */
    public function setViewPath($viewPath)
    {
        $this->viewPath = $viewPath;
    }



    public $appPath;

    /**
     *
     * @return the $appPath
     */
    public function getAppPath()
    {
        return $this->appPath;
    }

    /**
     *
     * @param field_type $appPath
     */
    public function setAppPath($appPath)
    {
        $this->appPath = $appPath;
    }

    /**
     * @var \ReflectionClass
     **/
    public $controllerReflectObj;

    /**
     * @return mixed $controllerReflectObj
     */
    public function getControllerReflectObj()
    {
        return $this->controllerReflectObj;
    }

    /**
     * @param mixed $controllerReflectObj
     */
    public function setControllerReflectObj($controllerReflectObj)
    {
        $this->controllerReflectObj = $controllerReflectObj;
    }


    /**
     *
     * @return the $controller
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     *
     * @return the $act
     */
    public function getAct()
    {
        return $this->act;
    }


    /**
     *
     * @param field_type $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     *
     * @param field_type $act
     */
    public function setAct($act)
    {
        $this->act = $act;
    }

    /**
     *
     * @return the $baseDir
     */
    public function getBaseDir()
    {
        return $this->baseDir;
    }

    /**
     *
     * @param field_type $baseDir
     */
    public function setBaseDir($baseDir)
    {
        $this->baseDir = $baseDir;
    }

    public $indexDir;

    /**
     * @return mixed
     */
    public function getIndexDir()
    {
        if (empty($this->indexDir)) {
            $this->setIndexDir();
            return $this->indexDir;
        } else
            return $this->indexDir;
    }

    /**
     * @param mixed $indexDir
     */
    public function setIndexDir()
    {
        $root = $_SERVER['DOCUMENT_ROOT'];//  echo $root,'<br>';
        $scriptFileName = dirname($_SERVER['SCRIPT_FILENAME']); // echo 'scrii',$scriptFileName,'<br>';
        $str = strtr($scriptFileName, array(
            $root => null
        ));
        $this->indexDir = $str;
    }

    use SingleInstance;

    /* 导入单例模式trait */
    function __clone()
    {
    }

    public function getExtention($key = null)
    { // var_dump($key,$this->getConfig('extentions')[$key]);
        if ($key) {
            return $this->getConfig('extentions')[$key] ?: null;
        }
    }

    public function run()
    {
       try {
           if (1 == $this->getConfig('RunMode')) {


               $runClass = Configer::getConfig('app.runClass.class');
               $runMethod = Configer::getConfig('app.runClass.method');
               $runObj = (new \ReflectionClass($runClass))->newInstance();
               call_user_func([$runObj, $runMethod]);
               // RequestServer::runRout($routArr);
           }
           $path=$this->getControllerInstance()->getClassFile();
           $this->setAppPath();
       } catch (\Exception $exception) {
           /* @var ExceptionController $exceptionController*/
          /* $exceptionController=Mini::createObj(ExceptionController::class);
           $exceptionController->assign("message",$exception->getMessage());
           $exceptionController->assign("file",$exception->getFile());
           $exceptionController->assign("line",$exception->getLine());
           $exceptionController->assign("code",$exception->getCode());
           $exceptionController->assign("trace",$exception->getTraceAsString());*/

           echo $exception->getMessage();
           echo $exception->getFile();
           echo $exception->getLine();
           echo $exception->getCode();
           echo $exception->getTraceAsString();
       }

    }

    public function __construct($config = null)
    { 
        if (is_null($config)) {
            $this->config = include dirname(__FILE__) . '/../config/Config.php';
        } else {
//            $config['indexDir'] = dirname(debug_backtrace(0, 1)[0]['file']) . '/cache/config';
//            $this->setConfig($config);
            Configer::setConfig($config);

        }

        Mini::$app = $this;
        self::setParams($config['params']);
        if (PHP_SESSION_DISABLED === session_status()) {
            session_start();
        }
    }
}

