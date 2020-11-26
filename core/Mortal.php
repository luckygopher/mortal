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

    static public function load($class)
    {
        $class = str_replace('\\','/',$class);
        $file = ROOT.'/'.$class.'.php';
        if (is_file($file)) {
            include $file;
        }else{
            return false;
        }
    }

    /**
     * 1、注入模版引擎对象
     * 2、写入全局变量到模版
     * @return void
     */
    static private function appView()
    {
        $loader = new \Twig_Loader_Filesystem(APP.'/views');
        $twig = new \Twig_Environment($loader, array(
            'cache' => ROOT.'/storage/cache',
            'debug' => DEBUG,
        ));
        App::set('twig',$twig);
        require CORE."/config/twigGlobal.php";
    }

    public function assign($key, $val)
    {
        $this->assignArr[$key] = $val;
    }

    public function display($viewFile)
    {
        // $filePath = APP.'/views/'.$viewFile;
        // if (is_file($filePath)) {
        //     extract($this->assignArr);
        //     include $filePath;
        // }else{
        //     throw new \Exception('找不到对应的视图文件'.$filePath);
        // }
        $twig = App::get('twig');
        echo $twig->render($viewFile, $this->assignArr);
    }
}