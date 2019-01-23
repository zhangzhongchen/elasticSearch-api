<?php
namespace app\controller;

use core\Request;
use app\model\Product;


class ProductController
{

    /**
     * 批量|单条 添加|修改 产品
     * @param Product $product
     * @param Request $request
     */
    public function addProduct(Request $request, Product $product)
    {
        $res = $product->productSaveAll($request::post());
        if ($res == 'error') {
            returnError('add product error!');
        }
        returnSuccess();
    }

    /**
     * 产品查询
     * @param Request $request
     * @param Product $product
     */
    public function productQuery(Request $request, Product $product)
    {
        $query = $request::post('query');
        if (!$query) {
            returnError('query params error!');
        }
        $res = $product->productQuery($query);
        if ($res == 'error') {
            returnError('query product error!');
        }
        if (count($res['hits']) == 1) {
            $res = $res['hits'][0]['_source'];
        }
        returnSuccess($res);
    }

}