<?php
namespace app\validate;

use core\Request;

class Sign
{

    /**
     * 验签
     * @param $request array 请求参数
     * @return bool
     */
    public function validate($request)
    {
        if ('validate success') {
            return true;
        }
        return_error('sign error!');
    }


}