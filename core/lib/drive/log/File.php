<?php
namespace core\lib\drive\log;

use core\lib\Config;


class File
{
    public $path;//日志存储目录

    public function __construct()
    {
        $this->path = Config::get('OPTION','log');
    }
    public function log($message, $file)
    {
        /**
         * 1.确定文件存储位置是否存在,不存在就新建
         * 2.写入日志
         */
        if (!is_dir($this->path['PATH'].date('YmdH'))) {
            mkdir($this->path['PATH'].date('YmdH'), 0777, true);
        }
        $filePath = $this->path['PATH'].date('YmdH').'/'.$file.'.php';
        $logdata = date('Y-m-d H:i:s')."\t\t".json_encode($message).PHP_EOL;
        return file_put_contents($filePath, $logdata, FILE_APPEND);
    }
}