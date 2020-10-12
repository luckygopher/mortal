<?php
/**
 * 入口文件
 * 1.定义常量
 * 2.加载函数库
 * 3.启动框架
 */
//realpath()获取绝对路径,dirname()获取路径的上一目录
define('ROOT', realpath(dirname(__FILE__)));
define('CORE', ROOT.'/core');
define('APP', ROOT.'/app');
define('__PUBLIC__', '/public');
define('DEBUG',true);

include "vendor/autoload.php";

if (DEBUG) {
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
    ini_set('display_errors', 'on');
}else{
    ini_set('display_errors', 'off');
}

include CORE.'/common/function.php';
include CORE.'/Mortal.php';

spl_autoload_register('core\Mortal::load');

core\Mortal::run();