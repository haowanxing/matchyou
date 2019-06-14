<?php
/**
 * Created by PhpStorm.
 * User: anthony
 * Date: 2019-06-03 10:19
 */

namespace matchYou;


abstract class Match
{
    protected static function isMatch($obj, $pattern)
    {
        if (preg_match($pattern, $obj)) {
            return true;
        }
        return false;
    }

    protected static function pickUp($obj, $pattern)
    {
        $matches = [];
        $ok = preg_match_all($pattern, $obj, $matches);
        return $ok?$matches[0]:[];
    }

    protected static function pattern($p, $o = '')
    {
        return '/'.$p.'/'.$o;
    }

    protected static function patternPackES($p, $o = '')
    {
        return self::pattern('^'.$p.'$', $o);
    }

    protected static function patternPackE($p, $o = '')
    {
        return self::pattern($p.'$', $o);
    }

    protected static function patternPackS($p, $o = '')
    {
        return self::pattern('^'.$p, $o);
    }

    /**
     * 判断对象是否是指定长度的十六进制数
     * @param $obj
     * @param int $len
     * @return bool
     */
    public static function isHex($obj, $len = 4)
    {
        if (strlen($obj) < 1 || strlen($obj) > $len) {
            return false;
        }
        $zero = ord('0');
        $nine = ord('9');
        $alpha = ord('A');
        $fire = ord('F');
        $items = str_split(strtoupper($obj));
        foreach ($items as $item) {
            $ascii = ord($item);
            if (!($ascii >= $zero && $ascii <= $nine) && !($ascii >= $alpha && $ascii <= $fire)) {
                return false;
            }
        }
        return true;
    }

}