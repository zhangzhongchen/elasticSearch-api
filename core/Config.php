<?php
namespace core;


class Config
{

    static $config;

    /**
     * @param $key string 支持二级配置 xxx.xxx
     * @return string
     */
    public static function get($key)
    {
        if (!static::$config) {
            static::$config = include(ROOT . 'common/config.php');
        }

        if (strpos($key, '.')) {
            $key = explode('.', $key);
            if (is_array($key)) {
                return isset(static::$config[$key[0]][$key[1]]) ? static::$config[$key[0]][$key[1]] : '';
            }
        }

        return isset(static::$config[$key]) ? static::$config[$key] : '';
    }


    /**
     * 获取单个索引的配置
     * @param $index string 索引名称(同文件名称)
     * @param $key
     * @return string
     */
    public static function getIndex($index, $key)
    {
        $filePath = ROOT . 'common/indexconfig/' . $index . '.php';
        if (!is_file($filePath)) {
            return '';
        }
        $indexConfig = include($filePath);
        if (strpos($key, '.')) {
            $key = explode('.', $key);
            if (is_array($key)) {
                return isset($indexConfig[$key[0]][$key[1]]) ? $indexConfig[$key[0]][$key[1]] : '';
            }
        }
        return isset($indexConfig[$key]) ? $indexConfig[$key] : '';
    }
}

