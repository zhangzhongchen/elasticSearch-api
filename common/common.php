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
function return_success($data = [], $msg = 'ok', $die = true)
{
    $resData = ['status' => 'success', 'msg' => $msg, 'data' => $data];
    Response::output($resData, $die);
}

/**
 * 错误返回
 * @param $msg
 * @param bool $die 是否中止执行
 */
function return_error($msg, $die = true)
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
function curl_requests($URL, $type, $params = [], $headers = true)
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
function es_res($res)
{
    $res = json_decode($res, 1);
    if (isset($res['error'])) {
        logs("es-error : " . json_encode($res['error']), 'request-response.log');
        return 'error';
    }
    return $res;
}

/**
 * 查询es时返回数据处理
 * 处理返回 并记录错误日志
 * @param $res
 * @param $model object 当前模型对象
 * @return string|array
 */
function query_res($res, $model)
{
    $res = json_decode($res, 1);
    if (isset($res['error'])) {
        logs("es-error : " . json_encode($res['error']), 'request-response.log');
        return 'error';
    }
    //没有查询到数据
    if (!isset($res['hits']['total']) || $res['hits']['total'] == 0) {
        return [];
    }
    $hits = $res['hits']['hits'];
    $total = $res['hits']['total'];
    //获取单条判断 返回一维数组
    if ($model->limit == 1) {
        return $hits[0]['_source'];
    }
    //重新组合数组
    foreach ($res['hits']['hits'] as $k => $value) {
        $value['_source']['relevance'] = $value['_score'];
        $list[] = $value['_source'];
    }

    $pageData = ['total' => $total, 'pageCount' => ceil($total / $model->limit), 'page' => $model->page, 'limit' => $model->limit, 'list' => $list];
    return $pageData;
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
    $logStr = "\r\n" . date('Y-m-d H:i:s') . " " . $data;
    $path = ROOT . 'log/' . $file;
    return file_put_contents($path, $logStr, FILE_APPEND, null);
}

