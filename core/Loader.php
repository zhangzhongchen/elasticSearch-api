<?php
namespace core;

use core\Response;
use function GuzzleHttp\Promise\exception_for;

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
        //composer 加载
        if (is_dir(VENDOR_PATH . 'composer')) {
                require VENDOR_PATH . 'autoload.php';
        }
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

