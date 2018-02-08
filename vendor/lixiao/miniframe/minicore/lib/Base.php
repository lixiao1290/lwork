<?php
namespace minicore\lib;

abstract class Base implements \Iterator
{
    public static $obj;
    
    /**
     *
     * {@inheritdoc}
     *
     * @see Iterator::current()
     */
    public function current()
    {
        // TODO Auto-generated method stub
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see Iterator::key()
     */
    public function key()
    {
        // TODO Auto-generated method stub
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see Iterator::next()
     */
    public function next()
    {
        // TODO Auto-generated method stub
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see Iterator::rewind()
     */
    public function rewind()
    {
        // TODO Auto-generated method stub
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see Iterator::valid()
     */
    public function valid()
    {
        // TODO Auto-generated method stub
    }

    public function getClassFile()
    {
        $class = new \ReflectionClass(static::class);
        return $class->getFileName();
    }

    public function getClassDir()
    {
        $class = new \ReflectionClass(static::class);
        return dirname($class->getFileName());
    }


    /**
     * @param unknown 初始化对象
     */
    public function miniObjInit($members=null)
    {
        if (empty($members)) {
            $members=Mini::$app->getExtention(static::class);
    
        }
        /*foreach ((array)$members as $key => $value) {

            if (property_exists(static::class, $key))
                $this->$key = $value;
        }*/
        var_dump($members);exit;
        return Mini::creatObjByArgs(static::class,$members);
    }

    /**
     * @param unknown 初始化对象
     */
    public static function ObjInit($members = null)
    {
        if (empty($members)) {
            $members = Mini::$app->getExtention(static::class);

        }
        /*foreach ((array)$members as $key => $value) {

            if (property_exists(static::class, $key))
                $this->$key = $value;
        }*/

        return Mini::creatObjByArgs(static::class, $members);
    }
    
    /**
     * 初始化静态属性
     * @param unknown $members
     */
    public static function miniObjInitStatic($members=null)
    { 
        if (empty($members)) {
            $members=Mini::$app->getExtention(static::class);
              
        }
         
        foreach ((array)$members as $key => $value) {
            $reflect=new \ReflectionClass(static::class);
            $staticVars=$reflect->getStaticProperties();
            if (array_key_exists($key, $staticVars))
                static::$$key = $value;
        }
    }
    

    public function PropFuncExist($name)
    {
        return property_exists(static::class, $name) || method_exists(static::class, $name);
    }
}

