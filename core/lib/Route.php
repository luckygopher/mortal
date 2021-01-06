<?php
namespace core\lib;

class Route
{
    public $appName;
    public $controller;
    public $action;

    public function __construct()
    {
        //xx.com/home/index/index
        //xx.com/home/index.php/index/index

        //xx.com/admin/index/index
        //xx.com/admin/index.php/index/index
        /**
         * 1.隐藏index.php
         * 2.获取参数部分
         * 3.返回对应的应用名、控制器、方法
         */
        if(isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/'){
            $path = $_SERVER['REQUEST_URI'];
            $pathArr = explode('/',trim($path,'/'));
            if (isset($pathArr[0])){
                $this->appName = $pathArr[0];
                unset($pathArr[0]);
            }
            if (isset($pathArr[1])){
                $this->controller = $pathArr[1];
                unset($pathArr[1]);
            }
            if (isset($pathArr[2])){
                $this->action = $pathArr[2];
                unset($pathArr[2]);
            }else{
                $this->action = Config::get('ACTION','route');
            }
            //url多余部分转换为get参数
            $count = count($pathArr);
            $i = 3;
            while($i < $count + 3){
                if(isset($pathArr[$i + 1])){
                    $_GET[$pathArr[$i]] = $pathArr[$i + 1];
                }
                $i = $i + 2;
            }
        }else{
            $this->appName = Config::get('APP_NAME', 'route');
            $this->controller = Config::get('CONTROLLER','route');
            $this->action = Config::get('ACTION','route');
        }
    }
}