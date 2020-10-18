<?php
namespace core\lib;

class Config
{
    static public $cacheConf = array();

    static public function get($name, $file)
    {
        /**
         * 1.判断配置文件是否存在
         * 2.判断配置是否存在
         * 3.缓存配置
         */
        if (isset(self::$cacheConf[$file])) {
            return self::$cacheConf[$file][$name];
        }else{
            $filePath = CORE.'/config/'.$file.'.php';
            if(is_file($filePath)){
                $conf = include $filePath;
                if (isset($conf[$name])) {
                    self::$cacheConf[$file] = $conf;
                    return $conf[$name];
                }else{
                    throw new \Exception('找不到配置项'.$name);
                }
            }else{
                throw new \Exception('找不到配置文件'.$filePath);
            }
        }
    }

    static public function all($file)
    {
        if (isset(self::$cacheConf[$file])) {
            return self::$cacheConf[$file];
        }else{
            $filePath = CORE.'/config/'.$file.'.php';
            if (is_file($filePath)) {
                $conf = include $filePath;
                self::$cacheConf[$file] = $conf;
                return $conf;
            }else{
                throw new \Exception('找不到配置文件'.$file);
            }
        }
    }
}