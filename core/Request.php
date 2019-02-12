<?php
namespace core;

class Request
{

    /**
     * @var array 请求数据
     */
    public $request;

    /**
     * @var string 控制器
     */
    public $action;

    /**
     * @var string 请求方法
     */
    public $method;


    function __construct()
    {
        $this->request = $_SERVER;
        $this->getUrl();
    }

    /**
     * 判断是否post
     * @return bool
     */
    public static function isPost()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'post') {
            return true;
        }
        return false;
    }

    /**
     * 获取包含post get 的数据
     * @param string $key
     * @param string $default
     * @return string
     */
    public static function getParams($key = '', $default = '')
    {
        if ($key == '') {
            return $_REQUEST;
        }
        return isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
    }

    /**
     * 获取post数据
     * @param string $key
     * @param string $default
     * @return string
     */
    public static function post($key = '', $default = '')
    {
        if ($key == '') {
            return $_POST;
        }
        return isset($_POST[$key]) ? $_POST[$key] : $default;
    }

    /**
     * 设置post数据
     * @param $array
     */
    public static function setPost($array)
    {
        $_POST = $array;
    }

    /**
     * 获取get 数据
     * @param string $key
     * @param string $default
     * @return string
     */
    public static function get($key = '', $default = '')
    {
        if ($key == '') {
            return $_GET;
        }
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }

    /**
     * 获取请求方式
     * @return mixed
     */
    public static function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * 获取控制器名称
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * 获取请求的方法
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * 获取url 设置控制器方法
     * @throws \Exception
     */
    public function getUrl()
    {
        $uri = parse_url($this->request["REQUEST_URI"]);
        if (strpos($uri["path"], $this->request["SCRIPT_NAME"]) !== false) {
            $url = substr($uri["path"], strlen($this->request["SCRIPT_NAME"]));
        } elseif (strpos($uri["path"], dirname($this->request["SCRIPT_NAME"])) !== false) {
            $url = substr($uri["path"], strlen(dirname($this->request["SCRIPT_NAME"])));
        }
        $urlArr = explode("/", trim($url, '/ '));
        if (count($urlArr) != 2) {
            throw new \Exception('Incorrect URL');
        }
        list($this->action, $this->method) = $urlArr;
    }

}

