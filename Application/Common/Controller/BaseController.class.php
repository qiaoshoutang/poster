<?php
namespace Common\Controller;
use Think\Controller;
/**
 * 前台基类
 */
class BaseController extends Controller {

    /**
     * 页面不存在
     * @return array 页面信息
     */
    protected function error404()
    {
        $this->error('页面不存在！');
    }

}