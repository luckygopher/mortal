<?php
/**
 * Global helpers file with misc functions.
 */

/**
 * 获取随机字符串
 * @param int $randLength 长度
 * @param int $addtime 是否加入当前时间戳
 * @param int $includenumber 是否包含数字
 * @return string
 */
if (! function_exists('rand_str')) {
    function rand_str($randLength = 6, $addtime = 0, $includenumber = 0)
    {
        if ($includenumber) {
            $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHJKLMNPQEST123456789';
        } else {
            $chars = 'abcdefghijklmnopqrstuvwxyz';
        }
        $len = strlen($chars);
        $randStr = '';
        for ($i = 0; $i < $randLength; $i++) {
            $randStr .= $chars[mt_rand(0, $len - 1)];
        }
        if ($addtime) {
            $randStr .= time();
        }
        return $randStr;
    }
}

/**
 * 跳转地址
 * @param $url
 */
if (! function_exists('rand_str')) {
    function jump($url)
    {
        header('Location:'.$url);
        exit();
    }
}