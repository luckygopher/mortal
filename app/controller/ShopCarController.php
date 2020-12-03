<?php
namespace app\controller;

use core\Mortal;


class ShopCarController extends Mortal
{
    public function index()
    {
        $this->assign('__PUBLIC__',__PUBLIC__);
        $this->display('shopcar/index.html');
    }
}