<?php
use core\Response;

/**
 * @param $data
 * @param bool $is_die true:终止执行 false:不终止执行
 */
function P($data, $is_die = true)
{
    echo "<pre><hr><br>";
    if (is_bool($data) || is_null($data)) {
        var_dump($data);
    } else {
        print_r($data);
    }
    echo "<pre><hr><br>";
    $is_die && exit();
}

/**
 * 成功返回
 * @param array $data
 * @param string $msg
 * @param bool $die 是否终止执行
 */
function returnSuccess($data = [], $msg = 'ok', $die = true)
{
    $resData = ['status' => 'success', 'msg' => $msg, 'data' => $data];
    Response::output($resData, $die);
}

/**
 * 错误返回
 * @param $msg
 * @param bool $die 是否中止执行
 */
function returnError($msg, $die = true)
{
    $resData = ['status' => 'error', 'msg' => $msg];
    Response::output($resData, $die);
}

/**
 * 模拟发送各种请求
 * @param $URL
 * @param $type
 * @param array $params
 * @param string $headers
 * @return array
 */
function curlRequests($URL, $type, $params = [], $headers = true)
{
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $URL);
    if ($headers) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $type = strtoupper($type);
    switch ($type) {
        case "GET" :
            curl_setopt($ch, CURLOPT_HTTPGET, true);
            $params && curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            break;
        case "POST":
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            break;
        case "PUT" :
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            break;
        case "DELETE":
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            break;
    }
    $file_contents = curl_exec($ch);
    curl_close($ch);

    return $file_contents;
}


/**
 * 与 es 交互时
 * 处理返回 并记录错误日志
 * @param $res
 * @return string|array
 */
function esRes($res)
{
    $res = json_decode($res, 1);
    if (isset($res['error'])) {
        $error = isset($res['error']['reason']) ? $res['error']['reason'] : $res['error'];
        logs("\r\n" . json_encode($error), 'elasticsearch-error.log');
        return 'error';
    }
    return isset($res['hits']) ? $res['hits'] : $res;
}

/**
 * 写入日志
 * @param $data
 * @param string $file
 * @return int
 */
function logs($data, $file = '')
{
    if ($file == '') {
        $file = 'system.log';
    }
    $path = ROOT . 'log/' . $file;
    return file_put_contents($path, $data, FILE_APPEND, null);
}

