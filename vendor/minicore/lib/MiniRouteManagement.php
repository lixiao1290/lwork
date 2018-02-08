<?php
namespace minicore\lib;

use minicore\interfaces\MiniPublicInterface;

abstract class MiniRouteManagement  
{
    abstract  function valid();
    abstract function __construct($routeArr);
    public $routeArr;   
}

