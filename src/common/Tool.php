<?php
/**
 * Created by PhpStorm.
 * User: anthony
 * Date: 2019-06-14 10:20
 */

namespace matchYou\common;


class Tool
{

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