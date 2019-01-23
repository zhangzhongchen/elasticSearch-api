<?php

namespace app\model;

use core\Model;
use core\Config;
use lib\Autograph;


class Product extends Model
{

    /**
     * @param $sql 语句
     * @return array
     */
    public function productQuery($sql)
    {
        $queryJson = $this->getDsl($sql);
        p($queryJson,0);

        $url = $this->url() . '_search';
        $res = curlRequests($url, 'POST', $queryJson);
        return esRes($res);
    }

    /**
     * 批量添加数据
     * @param $product array
     * @return string
     */
    public function productSaveAll($product)
    {
        $url = $this->url() . '_bulk';
        $data = $this->_indexData($product);
        $res = curlRequests($url, 'POST', $data);
        return esRes($res);
    }

    /**
     * 组合批量添加数据
     * @param $data
     * @return string
     */
    protected function _indexData($data)
    {
        $res = '';
        foreach ($data as $row) {
            $res .= '{"index": { "_index": "' . $this->getIndex() . '", "_type": "' . $this->getIndex() . '", "_id": "' . $row['entity_id'] . '" }}' . "\n";
            $res .= json_encode($row) . "\n";
        }
        return $res;
    }

}