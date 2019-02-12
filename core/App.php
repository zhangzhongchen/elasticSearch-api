<?php
namespace core;

use core\Response;
use core\Config;
use core\Request;

class App
{

    /**
     * 执行请求
     */
    public static function run()
    {
        $request = new Request();
        $action = $request->getAction() . 'Controller';
        $method = $request->getMethod();

        static::requestLog($request);

        $controllerPath = '\app\controller\\' . $action;
        $controller = new $controllerPath;

        static::_validate($request);

        static::_validateRequestMethod($request);

        static::_validateClassMethod($controller, $method);

        static::_start($controller, $method);
    }

    /**
     * 执行请求 注入需要的类
     * @param $controller
     * @param $method
     */
    protected static function _start($controller, $method)
    {
        $ReflectionFunc = new \ReflectionClass($controller);
        $methods = $ReflectionFunc->getMethod($method);
        $params = [];
        foreach ($methods->getParameters() as $Param) {
            $class_name = $Param->getClass()->getName();
            $params[] = new $class_name();
        }
        call_user_func_array([$controller, $method], $params);
    }

    /**
     * 执行验证器 一个或多个
     * @param $request
     */
    protected static function _validate($request)
    {
        if ($validate = Config::get(strtolower($request->getAction()))) {
            if (is_array($validate)) {
                foreach ($validate as $k => $v) {
                    $method = ucfirst($v);
                    $controller = '\app\validate\\' . $method;
                    $controller = new $controller();
                    call_user_func_array([$controller, 'validate'], [$request->getParams()]);
                }
            }
        }
    }

    /**
     * 验证请求方式
     * @param $request
     * @return bool
     */
    protected static function _validateRequestMethod($request)
    {
        if ($requestMethod = Config::get('requestMethod')) {
            $action = strtolower($request->getAction());
            if (is_array(Config::get('unwantedPost')) && in_array($action, Config::get('unwantedPost'))) {
                return true;
            }
            if (strtoupper($requestMethod) != Request::getRequestMethod()) {
                Response::setHeaderCode(500);
                return_error('request Method error Must post');
            }
        }
    }

    /**
     * 验证控制器方法
     * @param $controller
     * @param $method
     */
    protected static function _validateClassMethod($controller, $method)
    {
        if (!method_exists($controller, $method)) {
            Response::setHeaderCode(404);
            return_error('request method not found');
        }
    }

    /**
     * 写入请求日志 仅写入了请求地址 批量数据太大没有写入
     * @param $request
     */
    public static function requestLog($request)
    {
        logs("request : " . $request->getAction() . '/' . $request->getMethod(), 'request-response.log');
    }

}

