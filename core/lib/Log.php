<?php
namespace core\lib;

class Log
{
    /**
     * 1.确定日志的存储方式
     * 2.写日志
     */
    static $class;

    static public function init()
    {
        //确定存储方式
        $drive = Config::get('DRIVE','log');
        $class = '\core\lib\drive\log\\'.$drive;
        self::$class = new $class;
    }

    static public function log($message, $file = 'log')
    {
        self::$class->log($message, $file);
    }
}