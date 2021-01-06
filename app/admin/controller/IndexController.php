<?php


namespace app\admin\controller;


use core\Mortal;

/**
 * 后台首页控制器
 * Class IndexController
 * @package app\admin\controller
 */
class IndexController extends Mortal
{
    public function index()
    {
        $this->assign('__PUBLIC__', __PUBLIC__);
        $this->assign('metaTitle', '管理首页');
        $this->display('index/index.html');
    }
}