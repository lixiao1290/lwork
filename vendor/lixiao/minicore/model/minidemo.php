<?php
namespace minicore\model;

class minidemo
{
    public $flag;
    public function __construct($a,$b)
    {
        $this->flag=$a.$b;
    }
}

