<?php
namespace core;

use core\Response;

class Loader
{

    /**
     * 自动加载
     * @param $class
     * @return bool
     * @throws \Exception
     */
    public static function autoload($class)
    {
        $class = str_replace('\\', '/', $class);
        $path = ROOT . $class . '.php';

        if (!file_exists($path)) {
            Response::setHeaderCode(500);
            throw new \Exception($class . ' not found!');
        }
        include $path;
        return true;
    }

}

