<?php
namespace app\controller;

use core\Mortal;
use app\model\UserModel;

class UserController extends Mortal
{
    public function index()
    {
        $db = new UserModel();
        $data = $db->getUserInfo(1);
        $this->assign('data',$data);
        $this->assign('__PUBLIC__', __PUBLIC__);
        $this->display('user/index.html');
    }
}
