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
    /*------------------------------------list结构 start----------------------------------------------------*/
    /**
     * 增,构建一个列表(先进后去,类似栈)
     * @param String $key KEY名称
     * @param string $value 值
     * @param $timeOut |num  过期时间
     */
    public function lpush($key, $value, $timeOut = 0) {
        $re = $this->redisObj[$this->sn]->LPUSH($key, $value);
        if ($timeOut > 0) {
            $this->redisObj[$this->sn]->expire($key, $timeOut);
        }

        return $re;
    }

    /**
     * 增,构建一个列表(先进先去,类似队列)
     * @param string $key KEY名称
     * @param string $value 值
     * @param $timeOut |num  过期时间
     */
    public function rpush($key, $value, $timeOut = 0) {
        $re = $this->redisObj[$this->sn]->RPUSH($key, $value);
        if ($timeOut > 0) {
            $this->redisObj[$this->sn]->expire($key, $timeOut);
        }

        return $re;
    }

    /**
     * 查,获取所有列表数据（从头到尾取）
     * @param string $key KEY名称
     * @param int $head  开始
     * @param int $tail     结束
     */
    public function lranges($key, $head, $tail) {
        return $this->redisObj[$this->sn]->lrange($key, $head, $tail);
    }

    /**
     * Power by Mikkle
     * QQ:776329498
     * @param $key
     * @return mixed
     */

    public function rpop($key) {
        return $this->redisObj[$this->sn]->rPop($key);
    }
    public function lpop($key) {
        return $this->redisObj[$this->sn]->lpop($key);
    }

    /*------------------------------------list结构 end----------------------------------------------------*/
    /*------------------------------------set结构 start----------------------------------------------------*/
    /**
     * 增,构建一个集合(无序集合)
     * @param string $key 集合Y名称
     * @param string|array $value  值
     * @param int $timeOut 时间  0表示无过期时间
     * @return
     */
    public function sadd($key, $value, $timeOut = 0) {
        $re = $this->redisObj[$this->sn]->sadd($key, $value);
        if ($timeOut > 0) {
            $this->redisObj[$this->sn]->expire($key, $timeOut);
        }

        return $re;
    }

    /**
     * 查,取集合对应元素
     * @param string $key 集合名字
     */
    public function smembers($key) {
        $re = $this->redisObj[$this->sn]->exists($key); //存在返回1,不存在返回0
        if (!$re) {
            return false;
        }

        return $this->redisObj[$this->sn]->smembers($key);
    }

    /*------------------------------------set结构 end----------------------------------------------------*/

    /*------------------------------------sort set结构 start----------------------------------------------------*/
    /**
     * 增,改,构建一个集合(有序集合),支持批量写入,更新
     * @param string $key 集合名称
     * @param array $score_value key为scoll, value为该权的值
     * @return int 插入操作成功返回插入数量【,更新操作返回0】
     */
    public function zadd($key, $score_value, $timeOut = 0) {
        if (!is_array($score_value)) {
            return false;
        }

        $a = 0; //存放插入的数量
        foreach ($score_value as $score => $value) {
            $re = $this->redisObj[$this->sn]->zadd($key, $score, $value); //当修改时,可以修改,但不返回更新数量
            $re && $a += 1;
            if ($timeOut > 0) {
                $this->redisObj[$this->sn]->expire($key, $timeOut);
            }

        }
        return $a;
    }

    /**
     * 查,有序集合查询,可升序降序,默认从第一条开始,查询一条数据
     * @param $key ,查询的键值
     * @param $min ,从第$min条开始
     * @param $max,查询的条数
     * @param $order ,asc表示升序排序,desc表示降序排序
     * @return array|bool 如果成功,返回查询信息,如果失败返回false
     */
    public function zrange($key, $min = 0, $num = 1, $order = 'desc') {
        $re = $this->redisObj[$this->sn]->exists($key); //存在返回1,不存在返回0
        if (!$re) {
            return false;
        }
        //不存在键值
        if ('desc' == strtolower($order)) {
            $re = $this->redisObj[$this->sn]->zrevrange($key, $min, $min + $num - 1);
        } else {
            $re = $this->redisObj[$this->sn]->zrange($key, $min, $min + $num - 1);
        }
        if (!$re) {
            return false;
        }
        //查询的范围值为空
        return $re;
    }

    /**
     * 返回集合key中,成员member的排名
     * @param $key,键值
     * @param $member,scroll值
     * @param $type ,是顺序查找还是逆序
     * @return bool,键值不存在返回false,存在返回其排名下标
     */
    public function zrank($key, $member, $type = 'desc') {
        $type = strtolower(trim($type));
        if ($type == 'desc') {
            $re = $this->redisObj[$this->sn]->zrevrank($key, $member); //其中有序集成员按score值递减(从大到小)顺序排列,返回其排位
        } else {
            $re = $this->redisObj[$this->sn]->zrank($key, $member); //其中有序集成员按score值递增(从小到大)顺序排列,返回其排位
        }
        if (!is_numeric($re)) {
            return false;
        }
        //不存在键值
        return $re;
    }

    /**
     * 返回名称为key的zset中score >= star且score <= end的所有元素
     * @param $key
     * @param $member
     * @param $star,
     * @param $end,
     * @return array
     */
    public function zrangbyscore($key, $star, $end) {
        return $this->redisObj[$this->sn]->ZRANGEBYSCORE($key, $star, $end);
    }

    /**
     * 返回名称为key的zset中元素member的score
     * @param $key
     * @param $member
     * @return string ,返回查询的member值
     */
    function zscore($key, $member) {
        return $this->redisObj[$this->sn]->ZSCORE($key, $member);
    }
    /*------------------------------------sort set结构 end----------------------------------------------------*/
}
