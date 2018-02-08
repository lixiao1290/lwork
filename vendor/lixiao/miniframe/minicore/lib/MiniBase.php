<?php
namespace minicore\lib;

use minicore\config\Configer;
use minicore\interfaces\MiniInterface;

class MiniBase extends Base implements MiniInterface
{
    public static $app;
    
    private $config;
    /**
     *
     * {@inheritdoc}
     *
     * @see \minicore\interfaces\MiniBase::getConfig()
     */
    public function getConfig($key=NULL)
    {
            return Configer::getConfig($key);

    }
    public function setConfig( $value)
    {
        $this->config= $value;
    }
    public function getVersion()
    {
        return self::version;
    }
}

  