<?php
namespace core;

use core\Response;

class Error
{

    /**
     * 注册错误处理
     * @access public
     * @return void
     */
    public static function register()
    {
        error_reporting(E_ALL);
        set_error_handler([__CLASS__, 'appError']);
        set_exception_handler([__CLASS__, 'appException']);
    }

    /**
     * 错误处理
     * @access public
     * @param  integer $errNo 错误编号
     * @param  integer $errStr 详细错误信息
     * @param  string $errFile 出错的文件
     * @param  integer $errLine 出错行号
     */
    public static function appError($errNo, $errStr, $errFile = '', $errLine = 0)
    {
        $errorStrLog = "error:\r\n" . $errNo . '  ' . $errFile . ' : ' . $errLine . "\r\n" . $errStr;

        //记录错误日志
        logs($errorStrLog);

        $errorStr = $errNo . '  ' . $errFile . ' : ' . $errLine . "   " . $errStr;

        Response::setHeaderCode(500);

        //调试模式未开启 不显示详细错误信息
        if (!DEBUG) {
            return_error('unknown error');
        }

        switch ($errNo) {
            case E_ERROR:
                return_error($errorStr);
                break;
            case E_WARNING:
                return_error($errorStr, false);
                break;
            case E_NOTICE:
                return_error($errorStr, false);
                break;
            default:
                return_error($errorStr);
                break;
        }
    }

    /**
     * 未被捕获的异常处理
     * @param $e
     */
    public static function appException($e)
    {
        $exceptionStrLog = "not capture Exception:\r\n " . $e->getMessage();

        //记录错误日志
        logs($exceptionStrLog);

        Response::setHeaderCode(500);

        return_error('Exception : ' . $e->getMessage());
    }
}

