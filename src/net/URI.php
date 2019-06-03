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
    protected static $domain = '/^[a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9]?\.)+[a-zA-Z]{2,6}$/i';
    protected static $url = '/^((http:\/\/)|(https:\/\/)|(ftp:\/\/))?[a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9]?\.)+[a-zA-Z]{2,6}(\/)/i';
    protected static $httpsUrl = '/^https:\/\/[a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9]?\.)+[a-zA-Z]{2,6}(\/)/i';
    protected static $httpUrl = '/^http:\/\/[a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9]?\.)+[a-zA-Z]{2,6}(\/)/i';
    protected static $ip4Address = '/(?=(\b|\D))(((\d{1,2})|(1\d{1,2})|(2[0-4]\d)|(25[0-5]))\.){3}((\d{1,2})|(1\d{1,2})|(2[0-4]\d)|(25[0-5]))(?=(\b|\D))/';
    protected static $ip6Address = '/^([\\da-fA-F]{1,4}:){7}([\\da-fA-F]{1,4})$/';

    public static function isDomain($str)
    {
        return self::isMatch($str, self::$domain);
    }

    public static function isUrl($str)
    {
        return self::isMatch($str, self::$url);
    }

    public static function isHttpUrl($str)
    {
        return self::isMatch($str, self::$httpUrl);
    }

    public static function isHttpsUrl($str)
    {
        return self::isMatch($str, self::$httpsUrl);
    }

    public static function isIpv4($str)
    {
        return self::isMatch($str, self::$ip4Address);
    }

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
}