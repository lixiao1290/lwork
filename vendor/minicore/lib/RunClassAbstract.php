<?php
namespace minicore\lib;

use minicore\interfaces\MiniPublicInterface;

abstract class RunClassAbstract  
{
    public static function run()
    {
        return new static();
    }
    abstract function __construct();
    
}

