<?php
namespace core\lib;

class Route
{
    public $controller;
    public $action;

    public function __construct()
    {
        //xx.com/index/index
        //xx.com/index.php/index/index
        /**
         * 1.隐藏index.php
         * 2.获取参数部分
         * 3.返回对应的控制器和方法
         */
        if(isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/'){
            $path = $_SERVER['REQUEST_URI'];
            $pathArr = explode('/',trim($path,'/'));
            if(isset($pathArr[0])){
                $this->controller = $pathArr[0];
                unset($pathArr[0]);
            }
            if(isset($pathArr[1])){
                $this->action = $pathArr[1];
                unset($pathArr[1]);
            }else{
                $this->action = Config::get('ACTION','route');
            }
            //url多余部分转换为get参数
            $count = count($pathArr);
            $i = 2;
            while($i < $count + 2){
                if(isset($pathArr[$i + 1])){
                    $_GET[$pathArr[$i]] = $pathArr[$i + 1];
                }
                $i = $i + 2;
            }
        }else{
            $this->controller = Config::get('CONTROLLER','route');
            $this->action = Config::get('ACTION','route');
        }
    }
}