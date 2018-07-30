<?php
namespace minicore\traits;

trait ObjInit {

    /* 实例 */
    private static $instance;

    /* 初始化实例 */
    public static function instance(array $members = NULL)
    {
        self::$instance = new static();
        foreach ($members as $key => $value) {
            self::$instance->$key = $value;
        }
        return self::$instance;
    }

    private function __construct()
    {
         
    }
}

