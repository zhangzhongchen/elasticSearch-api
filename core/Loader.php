<?php
namespace core;

use core\Response;

class Loader
{

    /**
     * 自动加载
     * @access public
     * @param  string $class 类名
     * @return bool
     */
    public static function autoload($class)
    {
        $class = str_replace('\\', '/', $class);
        $path = ROOT . $class . '.php';

        if (!file_exists($path)) {
            Response::setHeaderCode(404);
            throw new \Exception($class . ' not found!');
        }
        include $path;
        return true;
    }

}

