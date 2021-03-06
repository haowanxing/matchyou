<?php
/**
 * Created by PhpStorm.
 * User: anthony
 * Date: 2019-06-13 11:22
 */

namespace matchYou\telecoms;


use matchYou\Match;

class Phone extends Match
{
    protected static $cnPhone = '/^((\+|00)?86[- ]?)?0?1[3-57-9][0-9]{9}$/';
    protected static $cnTelephone = '/^(010|02\d{1}|0[3-9]\d{2})-\d{7,9}(-\d+)?$/';
    protected static $cn400 = '/^400(-\d{3,4}){2}$/';

    /**
     * 中国大陆手机号
     * @param $str
     * @return bool
     */
    public static function isPhoneCn($str)
    {
        return self::isMatch($str, self::$cnPhone);
    }

    /**
     * 中国电话号
     * @param $str
     * @return bool
     */
    public static function isTelephoneCn($str)
    {
        return self::isMatch($str, self::$cnTelephone);
    }

    /**
     * 400企业电话
     * @param $str
     * @return bool
     */
    public static function isTel400($str)
    {
        return self::isMatch($str, self::$cn400);
    }
}