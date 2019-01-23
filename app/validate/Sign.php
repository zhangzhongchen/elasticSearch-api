<?php
namespace app\validate;

use core\Request;
use lib\Autograph;

class Sign
{

    /**
     * 验签
     * @param $post_data
     * @return bool
     */
    public function validate($post_data)
    {
        if ($post_data) {
            return true;
        }
        returnError('sign error!');
    }


}