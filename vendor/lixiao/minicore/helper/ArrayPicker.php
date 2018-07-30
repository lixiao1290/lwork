<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/4
 * Time: 15:51
 */

namespace minicore\helper;


class ArrayPicker
{
    public static $array;

    /**
     * @param mixed $array
     */
    public function setArray($array)
    {
        $this->array = $array;
    }
    public function __construct(array $array)
    {
        $this->setArray($array);
    }

    public static function get($patterm,$array)
    {
        $return=self::$array?self::$array:$array;
        $tok=strtok($patterm,'.');

        while($tok!==false) {
            $return=$return[$tok];
            $tok=strtok('.');
        }
        return $return;
    }

}