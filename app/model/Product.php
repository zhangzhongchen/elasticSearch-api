<?php

namespace app\model;

use core\Model;
use core\Config;
use lib\Autograph;

class Product extends Model
{

    //默认查询列表字段
    public $select = ['entity_id', 'name', 'price', 'special_price', 'small_image'];

    //默认where条件
    public $where = ['is_salable' => 1];


    /**
     * 产品查询
     * @param $query
     * @return array
     */
    public function productQueryEs($query)
    {
        //请求参数自动赋值到属性
        $queryJson = $this->getQueryJson($query);
        //手动赋值到属性
//        $queryJson = $this->where(['category_ids' => 122, 'like' => ['name' => '德国']])
//            ->select(['entity_id', 'name'])
//            ->page(1)
//            ->limit(15)
//            ->build();
        $url = $this->url() . '_search';
        $res = curl_requests($url, 'POST', $queryJson);
        return query_res($res, $this);
    }

    /**
     * 批量添加产品数据
     * @param $product array
     * @return string
     */
    public function productSaveAll($product)
    {
        $url = $this->url() . '_bulk';
        $data = $this->_compositeJsonData($product);
        $res = curl_requests($url, 'POST', $data);
        return es_res($res);
    }

    /**
     * 组合批量添加数据
     * @param $data
     * @return string
     */
    protected function _compositeJsonData($data)
    {
        $res = '';
        foreach ($data as $row) {
            $res .= '{"index": { "_index": "' . $this->index . '", "_type": "' . $this->index . '", "_id": "' . $row['entity_id'] . '" }}' . "\n";
            $res .= json_encode($row) . "\n";
        }
        return $res;
    }

}