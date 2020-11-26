<?php
/**
 * 启动框架
 */
namespace core;

use core\lib\Route;
use core\lib\Log;
use core\lib\App;

class Mortal
{
    public $assignArr = [];

    static public function run()
    {
        Log::init();
        self::appView();
        $obj = new Route();
        $controllerName = $obj->controller;
        $action = $obj->action;
        $classPath = APP.'/controller/'.$controllerName.'Controller.php';
        $newClass = '\\app\\controller\\'.$controllerName.'Controller';
        if(is_file($classPath)){
            $classObj = new $newClass();
            if(method_exists($classObj,$action)){
                $classObj->$action();
            }else{
                throw new \Exception('找不到方法'.$action);
            }
        }else{
            throw new \Exception('找不到控制器'.$controllerName);
        }
    }
}