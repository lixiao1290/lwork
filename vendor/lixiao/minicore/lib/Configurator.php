<?php

namespace minicore\lib;

use minicore\interfaces\Configable;

class Configurator extends Base implements Configable
{
    /**
     * @var array
     */
    private static $configs = array();

    /**
     * @var string $name the name of config
     *
     * Configer::getConfig('db.db')
     * @return the $configs
     */
    public function getConfigByName($name)
    {
        if (!empty($name)) {
            if (array_key_exists($name, self::$configs))
                return self::$configs[$name];
        }
    }

    public function getConfigs()
    {
        return self::$configs;
    }

    public function getConfigByPatterm($patterm = null)
    {
        $return = self::$configs;
        $tok = strtok($patterm, '.');
        while ($tok !== false) {
            $return = $return[$tok];
            $tok = strtok('.');
        }
        return $return;
    }


    /**
     *
     * @param multitype : $configs
     */
    public function setConfig($configs, $name)
    {
        self::$configs[$name] = $configs;
    }

    /**
     * Configer constructor.
     */
    public function __construct($configs)
    {
        self::$configs = $configs;
    }

}

  