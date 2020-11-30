<?php
namespace app\controller;

use core\Mortal;
use core\lib\FileUpload;
use core\lib\Config;
class IndexController extends Mortal
{
    public function index()
    {
        $this->assign('__PUBLIC__', __PUBLIC__);
        $this->display('index/index.html');
    }

    public function upload()
    {
        if (isset($_POST['submit'])) {
            $uploadObj = new FileUpload(Config::all('upload'));
            if ($uploadObj->uploadFile('pic')) {
                var_dump($uploadObj->getNewFileName());
            }else {
                var_dump($uploadObj->getErrorMsg());
            }
        }else{
            $this->display('index/upload.html');
        }
    }
}