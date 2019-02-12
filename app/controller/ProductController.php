<?php
namespace app\controller;

use core\Request;
use app\model\Product;


class ProductController
{

    /**
     * 产品查询
     * @param Request $request
     * @param Product $product
     */
    public function productQuery(Request $request, Product $product)
    {
        $res = $product->productQueryEs($request::post());
        if ($res == 'error') {
            return_error('query product error!');
        }
        return_success($res);
    }

    /**
     * 批量|单条 添加|修改 产品
     * @param Product $product
     * @param Request $request
     */
    public function addProduct(Request $request, Product $product)
    {
        $res = $product->productSaveAll($request::post());
        if ($res == 'error') {
            return_error('add product error!');
        }
        return_success();
    }

}