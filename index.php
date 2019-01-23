<?php

//是否开启调试模式
define('DEBUG', true);

//设置时区
date_default_timezone_set('PRC');

define('ROOT', str_replace('\\', '/', realpath(dirname(__FILE__) . '/')) . "/");
define('APP_PATH', __DIR__ . '/app/');
define('CORE_PATH', __DIR__ . '/core/');

// 载入Loader类
require CORE_PATH . 'Loader.php';

//加载公共函数
require ROOT . '/common/common.php';

//注册系统自动加载
spl_autoload_register('core\\Loader::autoload', true, true);

//注册异常和错误处理
\core\Error::register();

//运行
\core\App::run();

