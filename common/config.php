<?php


return [

    //查询es请求的地址 端口
    'host' => 'http://localhost:9200/',

    //设置控制器 验证器 ['sign','xxx'] 可以多个
    'product' => ['sign'],

    //请求方式 必须post
    'requestMethod' => 'post',

    //不强制post请求的控制器
    'unwantedPost' => ['index'],

    //输出返回格式
    'returnFormat' => 'json',

];


