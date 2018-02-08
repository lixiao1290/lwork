<?php

namespace minicore\lib;

class ControllerBase extends Base
{

    /**
     * @var
     */
    private $css;

    /**
     * @var
     */
    private $js;

    /**
     * @var
     */
    private $viewVars;

    /**
     * @var
     */
    private $pageFunc;

    /**
     * @var string
     * 视图文件存放路径
     */
    private $viewPath;

    /**
     * @return string
     */
    public function getViewPath()
    {
        return $this->viewPath;
    }

    /**
     * @param string $viewPath
     */
    public function setViewPath($viewPath)
    {
        $this->viewPath = $viewPath;
    }

    /**
     *
     * @return the $css
     */
    public function getCss()
    {
        return $this->css;
    }

    /**
     *
     * @return the $js
     */
    public function getJs()
    {
        return $this->js;
    }

    /**
     *
     * @return the $viewVars
     */
    public function getViewVars()
    {
        return $this->viewVars;
    }

    /**
     * ControllerBase constructor.
     */
    public function __construct()
    {
        if (method_exists(get_called_class(), 'initial')) {
            $this->initial();
        }
        $path = dirname($this->getClassDir()) . '\views';
        $this->viewPath = $path;
        $this->setViewPath($path);
        Mini::$app->setViewPath($path);
        // echo $this->viewPath;
    }

    /**
     *
     */
    public function head()
    {
        while (list ($key, $value) = each($this->css)) {
            echo '<!-----', $key, '----->
', '<link rel="stylesheet" href=" ', $value, '"/>
                ';
        }
    }

    /**
     *
     */
    public function body()
    {
        while (list ($key, $value) = each($this->js)) {
            echo '<!-----', $key, '----->
', '<script type="application/javascript" src="', $value, '"></script>
                ';
        }
    }

    /**
     * @param null $path
     */
    public function includeFile($path = null)
    {
        $file = Mini::$app->getViewPath() . '//' . $path;
        include $file;
    }

    /**
     * 绑定变量
     *
     * @param unknown $key
     * @param unknown $value
     */
    public function assign($key, $value)
    {
        $this->viewVars[$key] = $value;
    }

    /**
     * 调用视图文件直接显示
     *
     * @param unknown $path
     */
    public function view($path = NULL)
    {
        // exit;
        if (is_null($path)) {
            // print_r(dirname());
            // echo '@',__FUNCTION__;

            $actdir = Mini::$app->getControllerName();
            $actfile = Mini::$app->getAct();
            $filename = $this->getViewPath() . '\\' . strtolower($actdir) . '\\' . strtolower($actfile) . '.' . Mini::$app->getConfig('viewSuffix');
            // var_dump('<pre>',debug_backtrace());
            if (file_exists($filename)) {
                extract($this->viewVars);

                include $filename;
                exit;
            } else {
                echo "未找到视图文件";
            }
        }
    }

    /**
     *
     */
    public function beforeView()
    {
        if ($layout = Mini::$app->getConfig('layout')) {
        }
    }

    /**
     *
     * @param unknown $js注册当前页面js文件
     */
    public function registerJs($js)
    {
        if (is_array($js)) {
            while (list ($key, $value) = each($js)) {
                $this->js[$key] = $value;
            }
        } else {
            $this->js[key($js)] = $js;
        }
    }

    /**
     *
     * @param unknown $cs注册当前页面css
     */
    public function registerCss($cs)
    {
        if (is_array($cs)) {
            while (list ($key, $value) = each($cs)) {
                $this->css[$key] = $value;
            }
        } else {
            $this->css[key($cs)] = $cs;
        }
    }

    /**
     * @param $widget
     */
    public static function widget($widget)
    {
        $path = Mini::$app->getConfig('controllerNamespace');
        $widgetObj = new dirname($path) . '\widget\\' . $widget();
        $widgetObj->run();
    }
}

