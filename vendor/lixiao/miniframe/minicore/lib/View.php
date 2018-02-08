<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/24 0024
 * Time: 下午 16:23
 */

namespace minicore\lib;


/**
 * Class View
 * @package minicore\lib
 */
class View
{
    /**
     * @param null $path
     * @return int
     */
    public static function view($path = NULL)
    {
        if (is_null($path)) {

            $actdir = Mini::$app->getControllerName();
            $actfile = Mini::$app->getAct();
            $filename = Mini::$app->getControllerInstance()->getViewPath() . '\\' . strtolower($actdir) ;
            $filename.='\\' . strtolower($actfile) . '.' . Mini::$app->getConfig('viewSuffix');
            // var_dump('<pre>',debug_backtrace());
            if (file_exists($filename)) {
                extract(Mini::$app->getControllerInstance()->getViewVars());

                include $filename;
                return 0;
            } else {
                echo "未找到视图文件";
            }
        }
    }
}