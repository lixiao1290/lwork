<?php

namespace minicore\lib;

/**
 * @author lixiao
 * lixiao.god@163.com
 *
 */

/**
 * Class Mini
 * @package minicore\lib
 */
class Mini
{

    /**
     * @var  \minicore\lib\MiniApp $app
     *
     */
    public static $app;

    public static function app($name=null)
    {
        if (is_object(self::$app)) {
            return self::$app;
        }
        if (is_array(self::$app)) {
            if (array_key_exists(self::$app, $name)) {
                return self::$app[$name];
            }
        }
    }

    public static function setApp($name, $app)
    {
        self::$app[$name]=$app;
    }

    /**
     * Mini constructor.
     */
    public function __construct()
    {
    }


    /**
     * @param $name classname
     * @return object
     */
    public static function createObj($name)
    {
        if (!class_exists($name)) {
            throw new \Exception("class " . $name . " not found");
        }
        $reflectionClass = new \ReflectionClass($name);
        $reflectionMethod = $reflectionClass->getConstructor();
        if ($reflectionClass->getConstructor()) {
            /**  if the class  has   constructor*/
            $parameter = $reflectionClass->getConstructor()->getParameters();
            if ($parameter) {
                /**if the constuctor  has parameters*/
                $actualParameters = array();
                /**   */
                foreach ($parameter as $parameter) {
                    $className = $parameter->getClass()->getName();
                    try {
                        if (class_exists($className)) {
                            $actualParameters[] = static::createObj($className);
                        } else {
                            throw new \Exception("class " . $classname . "  not found");
                        }
                    } catch (\Exception $e) {
                        echo $e->getMessage();
                    }
                }
//            var_dump($name, $actualParameters);
                $obj = $reflectionClass->newInstanceArgs($actualParameters);
            } else {
                /**if the constuctor  has not parameters*/
                $obj = $reflectionClass->newInstance();
            }
        } else {
            /**if the class  has not constructor*/
            $obj = $reflectionClass->newInstanceWithoutConstructor();
        }
        return $obj;
    }

    /**
     * create object from args
     * @param $classname
     * @param $args
     * @return object
     */
    public static function creatObjByArgs($classname, $args)
    {
        try {
            if (class_exists($classname)) {
                $reflectionClass = new \ReflectionClass($classname);
                $reflectionMethod = $reflectionClass->getConstructor();
                if ($reflectionClass->getConstructor()) {
                    /** if the class  has   constructor*/
                    $parameters = $reflectionClass->getConstructor()->getParameters();
                    if ($parameters) {
                        $actualParameters = array();
                        foreach ($parameters as $parameter) {
                            $actualParameters[] = $args[$parameter->name];
                        }
                        $obj = $reflectionClass->newInstanceArgs($actualParameters);

                    } else { /*if the class  has no  parameters*/
                        $obj = $reflectionClass->newInstance();
                    }
                } else {
                    /**  #if the class  has no  constructor*/
                    $obj = $reflectionClass->newInstanceWithoutConstructor();
                }
            } else {
                throw new \Exception("class " . $classname . "  not found");
            }
            return $obj;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

    }

    /**
     * @param $reflectionClass
     */
    public static function creatObjByReflectionClass($reflectionClass)
    {

    }
}

