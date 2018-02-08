<?php
namespace minicore\lib;

class MiniContainer
{
   public static  $app;

 
   
   /**
    * @var array 类的反射对象
    */
   private $_reflections = [];
   /**
    * @var array 类反射的依赖，构造函数参数
    */
   private $_dependencies = [];
   /**
     * @return the $app
     */
    public static function getApp()
    {
        return MiniContainer::$app;
    }

/**
     * @param field_type $app
     */
    public static function setApp($app)
    {
        MiniContainer::$app = $app;
    }

    /*  单例模式获取对象*/
    public function __construct()
    {


    }
    /**
     * @var 注册的依赖数组
     */
    protected static $registry = array();

    /**
     * 添加一个resolve到registry数组中
     * @param  string $name 依赖标识
     * @param  object $resolve 一个匿名函数用来创建实例
     * @return void
     */
    public static function register($name, \Closure $resolve)
    {

        static::$registry[$name] = $resolve;

    }
    /**
     * @param unknown $name
     * @param \Closure $resolve 闭包 依赖
     * @return boolean|mixed 返回一个单例
     */
    public static function getSoleStance($name, \Closure $resolve)
    {
        if(self::registered($name)) {
            return static::$registry[$name];
        } else {
            static::$registry[$name] = $resolve;
            return static::$registry[$name];
        }
    }

    /**
     * 返回一个实例
     * @param  string $name 依赖的标识
     * @return mixed
     */
    public static function getService($name)
    {
        if ( static::registered($name) )
        {
            $name = static::$registry[$name];
            return $name();
        }
        throw new Exception('该类未注册');
    }
    /**
     * 查询某个依赖实例是否存在
     * @param  string $name id
     * @return bool
     */
    public static function registered($name)
    {
        return array_key_exists($name, static::$registry);
    }
    public  function __set($name, \Closure $resolve)
    {
        self::register($name, $resolve);
    }
    public  function __get($name)
    {
        self::getInstance($name);
    }
    public static function getDependencies($class)
    {
        if (isset($this->_reflections[$class])) {
            return [$this->_reflections[$class], $this->_dependencies[$class]];
        }

        $dependencies = [];
        $reflection = new ReflectionClass($class);

        $constructor = $reflection->getConstructor();
        if ($constructor !== null) {
            foreach ($constructor->getParameters() as $param) {
                if ($param->isDefaultValueAvailable()) {
                    $dependencies[] = $param->getDefaultValue();
                } else {
                    $c = $param->getClass();
                    $dependencies[] = Instance::of($c === null ? null : $c->getName());
                }
            }
        }

        $this->_reflections[$class] = $reflection;
        $this->_dependencies[$class] = $dependencies;

        return [$reflection, $dependencies];
    }
    public static function iniDependencies($dependencies,$reflection)
    {

        foreach ($dependencies as $index => $dependency) {
            
        }
        return $dependencies;
        
    }
    public static function creatObjByConfig($class,$config)
    {
        
    }
    
}

