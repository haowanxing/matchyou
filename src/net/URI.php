<?php
/**
 * Created by PhpStorm.
 * User: anthony
 * Date: 2019-06-03 10:03
 */

namespace matchYou\net;


use matchYou\Match;

class URI extends Match
{
    protected static $domain = '[a-zA-Z0-9](?:[a-zA-Z0-9\-]{0,61}[a-zA-Z0-9]?\.)+[a-zA-Z]{2,6}';
    protected static $url = '(?:(?:http:\/\/)|(?:https:\/\/)|(?:ftp:\/\/))?[a-zA-Z0-9](?:[a-zA-Z0-9\-]{0,61}[a-zA-Z0-9]?\.)+[a-zA-Z]{2,6}[a-zA-Z0-9\-\.\!\*\'\(\);_\:@&=+$,\/\?#\[\]]*';
    protected static $httpsUrl = '/^https:\/\/[a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9]?\.)+[a-zA-Z]{2,6}(\/)/i';
    protected static $httpUrl = '/^http:\/\/[a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9]?\.)+[a-zA-Z]{2,6}(\/)/i';
    protected static $ftpUrl = '/^ftp:\/\/(.*:.*)?(((?=(\b|\D))(((\d{1,2})|(1\d{1,2})|(2[0-4]\d)|(25[0-5]))\.){3}((\d{1,2})|(1\d{1,2})|(2[0-4]\d)|(25[0-5]))(?=(\b|\D)))|([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9]?\.)+[a-zA-Z]{2,6}))(:\d)?(\/.*)?/';
    protected static $ip4Address = '/(?=(\b|\D))(((\d{1,2})|(1\d{1,2})|(2[0-4]\d)|(25[0-5]))\.){3}((\d{1,2})|(1\d{1,2})|(2[0-4]\d)|(25[0-5]))(?=(\b|\D))/';
    protected static $ip6Address = '/^([\\da-fA-F]{1,4}:){7}([\\da-fA-F]{1,4})$/';
    protected static $email = '/^[A-Za-z0-9\-\._\u4e00-\u9fa5]+@[a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9]?\.)+[a-zA-Z]{2,6}$/';

    /**
     * 合法域名
     * @param $str
     * @return bool
     */
    public static function isDomain($str)
    {
        $pattern = self::patternPackES(self::$domain);
        return self::isMatch($str, $pattern);
    }

    /**
     * 提取域名
     * @param $str
     * @return string
     */
    public static function pickDomain($str)
    {
        $pattern = self::pattern(self::$domain);
        return self::pickUp($str, $pattern);
    }

    /**
     * 合法URL,支持http/https/ftp协议
     * @param $str
     * @return bool
     */
    public static function isUrl($str)
    {
        $pattern = self::patternPackS(self::$url, 'i');
        return self::isMatch($str, $pattern);
    }

    /**
     * 提取URL
     * @param $str
     * @return mixed|string
     */
    public static function pickUrl($str)
    {
        $pattern = self::pattern(self::$url, 'i');
        return self::pickUp($str, $pattern);
    }

    /**
     * http地址
     * @param $str
     * @return bool
     */
    public static function isHttpUrl($str)
    {
        return self::isMatch($str, self::$httpUrl);
    }

    /**
     * https地址
     * @param $str
     * @return bool
     */
    public static function isHttpsUrl($str)
    {
        return self::isMatch($str, self::$httpsUrl);
    }

    /**
     * ftp地址
     * @param $str
     * @return bool
     */
    public static function isFtpUrl($str)
    {
        return self::isMatch($str, self::$ftpUrl);
    }

    /**
     * IPv4地址
     * @param $str
     * @return bool
     */
    public static function isIpv4($str)
    {
        return self::isMatch($str, self::$ip4Address);
    }

    /**
     * IPv6地址
     * @param $str
     * @return bool
     */
    public static function isIpv6($str)
    {
        $idx = strpos($str, '::');
        if ($idx === false){
            return self::isMatch($str, self::$ip6Address);
        }else{
            // there is two "::"
            if($idx !== strrpos($str, '::')){
                return false;
            }
            $items = explode('::', $str);
            $item0 = explode(':', $items[0]);
            $item1 = explode(':', $items[1]);
            if(count($item0) + count($item1) > 7){
                return false;
            }
            foreach ($item0 as $item){
                if (!self::isHex($item, 4)){
                    return false;
                }
            }
            foreach ($item1 as $item){
                if (!self::isHex($item, 4)){
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * 电子邮箱地址
     * @param $str
     * @return bool
     */
    public static function isEmail($str)
    {
        return self::isMatch($str, self::$email);
    }
}