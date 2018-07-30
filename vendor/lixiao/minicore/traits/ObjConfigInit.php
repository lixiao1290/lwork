<?php
namespace minicore\traits;

use minicore\lib\Mini;

trait ObjConfigInit
{
    public function miniObjInit($members=null)
    {
        if (empty($members)) {
            $members=Mini::$app->getExtention(static::class);
    
        }
        foreach ($members as $key => $value) {
            if (property_exists(static::class, $key))
                $this->$key = $value;
        }
    
    }
    
    public static function miniObjInitStatic($members)
    {
        if (empty($members)) {
            $members=Mini::$app->getExtention(static::class);
                
        }
        foreach ($members as $key => $value) {
            $reflect=new \ReflectionClass(static::class);
            $staticVars=$reflect->getStaticProperties();
            if (array_key_exists($key, $staticVars))
                static::$$key = $value;
        }
    }
}

