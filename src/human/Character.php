<?php
/**
 * Created by PhpStorm.
 * User: anthony
 * Date: 2019-06-13 16:30
 */

namespace matchYou\human;


use matchYou\Match;

class Character extends Match
{
    protected static $chinese = '/^[\x{4e00}-\x{9fa5}]{0,}$/u';
    protected static $englishOnly = '/^[A-Za-z]+$/';
    protected static $englishAndNumbers = '/^[A-Za-z0-9]+$/';
    protected static $capitalLetterOnly = '/^[A-Z]+$/';
    protected static $lowerLetterOnly = '/^[a-z]+$/';
    protected static $goodAccount = '/^[a-zA-Z][A-Za-z0-9_]{4,15}$/';


    /**
     * 仅包含中文
     * @param $str
     * @return bool
     */
    public static function isChineseOnly($str)
    {
        return self::isMatch($str, self::$chinese);
    }

    /**
     * 仅包含英文
     * @param $str
     * @return bool
     */
    public static function isEnglishOnly($str)
    {
        return self::isMatch($str, self::$englishOnly);
    }

    /**
     * 仅包含英文和数字
     * @param $str
     * @return bool
     */
    public static function isEnglishNumbers($str)
    {
        return self::isMatch($str, self::$englishAndNumbers);
    }

    /**
     * 仅包含大写字母
     * @param $str
     * @return bool
     */
    public static function isCapitalLetterOnly($str)
    {
        return self::isMatch($str, self::$capitalLetterOnly);
    }

    /**
     * 仅包含小写字母
     * @param $str
     * @return bool
     */
    public static function isLowerLetterOnly($str)
    {
        return self::isMatch($str, self::$lowerLetterOnly);
    }

    /**
     * 用户名（账号名）以字母开头，支持字母数字下划线，5-16字节
     * @param $str
     * @return bool
     */
    public static function isGoodAccountName($str)
    {
        return self::isMatch($str, self::$goodAccount);
    }
}