<?php
namespace minicore\helper;

class DbContainer
{
    public static  $db;
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
}

