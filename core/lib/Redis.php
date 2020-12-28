<?php

namespace core\lib;

class Redis {
    public $redisObj = null; //redis实例化时静态变量

    static protected $instance;
    protected $sn;
    protected $index;

    public function __construct($options = []) {
        $host = trim(isset($options["host"]) ? $options["host"] : '127.0.0.1');
        $port = trim(isset($options["port"]) ? $options["port"] : 6379);
        $auth = trim(isset($options["auth"]) ? $options["auth"] : "root");
        $index = trim(isset($options["index"]) ? $options["index"] : 0);
        if (!is_integer($index) && $index > 16) {
            $index = 0;
        }
        $sn = md5("{$host}{$port}{$auth}{$index}");
        $this->sn = $sn;
        if (!isset($this->redisObj[$this->sn])) {
            $this->redisObj[$this->sn] = new \Redis();
            $this->redisObj[$this->sn]->connect($host, $port);
            $this->redisObj[$this->sn]->auth($auth);
            $this->redisObj[$this->sn]->select($index);
        }
        $this->redisObj[$this->sn]->sn = $sn;
        $this->index = $index;
        return;
    }

    /**
     * @param array $options
     * @return Redis
     */
    public static function instance($options = []) {
        return new Redis($options);
    }

    /**
     * @param $key
     * @param int $time
     * @return bool
     */
    public function setExpire($key, $time = 0) {

        if (!$key) {
            return false;
        }
        switch (true) {
            case ($time == 0):
                return $this->redisObj[$this->sn]->expire($key, 0);
                break;
            case ($time > time()):
                $this->redisObj[$this->sn]->expireAt($key, $time);
                break;
            default:
                return $this->redisObj[$this->sn]->expire($key, $time);
        }
    }

    /*------------------------------------string结构 start----------------------------------------------------*/
    /**
     * 增,设置值  构建一个字符串
     * @param string $key KEY名称
     * @param string $value  设置值
     * @param int $timeOut 时间  0表示无过期时间
     * @return true【总是返回true】
     */
    public function set($key, $value, $timeOut = 0) {
        $setRes = $this->redisObj[$this->sn]->set($key, $value);
        if ($timeOut > 0) {
            $this->redisObj[$this->sn]->expire($key, $timeOut);
        }

        return $setRes;
    }

    /**
     * 查,获取 某键对应的值,不存在返回false
     * @param $key ,键值
     * @return bool|string ,查询成功返回信息,失败返回false
     */
    public function get($key) {
        $setRes = $this->redisObj[$this->sn]->get($key); //不存在返回false
        if ($setRes === 'false') {
            return false;
        }
        return $setRes;
    }
    /*------------------------------------string结构 end----------------------------------------------------*/
}
