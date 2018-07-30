<?php

namespace minicore\helper;

/**
 *
 * @author lixiao
 *         数据库操作类
 */

use app\main\controllers\base;
use minicore\lib\Mini;

/**
 * Class Db
 * @package minicore\helper
 */
class Db extends base
{
    /**
     * @param $args array(
     * "host" => "localhost",
     * "port" => "3306",
     * "db" => "test",
     * "user" => "root",
     * "pwd" => "root",
     * "type" => "mysql"
     * )
     * @return \DbHelper
     */
    public static function db($args)
    {
        /* @var  \DbHelper $dbHelper */
        $dbHelper = Mini::creatObjByArgs(DbHelper::class, $args);
        return $dbHelper;
    }

}

