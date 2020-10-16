<?php
/**
 * @author Augus <mr_augus@qq.com>
 * @category 依赖注入容器
 */
namespace core\lib;

class App
{
    protected static $container = [];
    /**
     * 注入
     *
     * @param [type] $key
     * @param [type] $val
     * @return void
     */
    public static function set($key, $val)
    {
        self::$container[$key] = $val;
    }
    /**
     * 获取
     *
     * @param [type] $key
     * @return void
     */
    public static function get($key)
    {
        if (!array_key_exists($key, self::$container)) {
            throw new Exception("not find".$key);
        }
        return self::$container[$key];
    }
}