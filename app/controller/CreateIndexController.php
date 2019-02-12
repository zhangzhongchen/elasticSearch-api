<?php
namespace app\controller;

use core\Request;
use core\Config;


class CreateIndexController
{

    /**
     * 创建索引 自定义配置
     */
    public function addIndex(Request $request)
    {
        $index = $request::getParams('index');
        if (!$index) {
            return_error('index parameters not null!');
        }
        $index = strtolower($index);
        $analyzer = Config::getIndex($index,'customIndex');
        $host = Config::get('host');
        $url = $host . $index . '/' . $index;
        $indexRes = curl_requests($host . $index, 'PUT', $analyzer);
        if ($indexRes != 'error') {
            $typeSetting = json_encode((object)[]);
            if ($customWord = Config::getIndex($index,'customWord')) {
                $typeSetting = $customWord;
                $url = $url . '/_mapping';
            }
            $indexRes = curl_requests($url, 'POST', $typeSetting);
        }
        if ($indexRes != 'error') {
            return_success('Create Index ok!');
        }
        return_error('Create Index error!');
    }
}