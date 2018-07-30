<?php
namespace minicore\lib;


class Widget extends ControllerBase
{
    /**
     * {@inheritDoc}
     * @see \minicore\lib\ControllerBase::registerCss()
     */
    public function registerCss($cs)
    {
        // TODO Auto-generated method stub
        Mini::$app->getControllerStance()->registerCss($cs);
    }

    /**
     * {@inheritDoc}
     * @see \minicore\lib\ControllerBase::registerJs()
     */
    public function registerJs($js)
    {
        // TODO Auto-generated method stub
        Mini::$app->getControllerStance()->registerJs($cs);
        
    }

    /**
     * {@inheritDoc}
     * @see \minicore\lib\ControllerBase::view()
     */
    public function view($path = NULL)
    {
        // TODO Auto-generated method stub
        var_dump(debug_backtrace());
    }

    
}

