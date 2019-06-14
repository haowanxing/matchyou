<?php
/**
 * Created by PhpStorm.
 * User: anthony
 * Date: 2019-06-14 10:07
 */

namespace matchYou\expression;


abstract class ExpAbs
{
    protected $domainExp = '[a-zA-Z0-9](?:[a-zA-Z0-9\-]{0,61}[a-zA-Z0-9]?\.)+[a-zA-Z]{2,6}';
    protected $urlExp = '(?:(?:http:\/\/)|(?:https:\/\/)|(?:ftp:\/\/))?[a-zA-Z0-9](?:[a-zA-Z0-9\-]{0,61}[a-zA-Z0-9]?\.)+[a-zA-Z]{2,6}[a-zA-Z0-9\-\.\!\*\'\(\);_\:@&=+$,\/\?#\[\]]*';
    protected $emailExp = '[A-Za-z0-9\-\._\u4e00-\u9fa5]+@[a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9]?\.)+[a-zA-Z]{2,6}';
    protected $chineseExp = '[\x{4e00}-\x{9fa5}]+';
    protected $idCard2GExp = '[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0-2]\d)|(3[0-1]))\d{3}[\dxX]{1}';
    protected $idCard1GExp = '[1-9]\d{5}\d{2}((0\d)|(1[0-2]))(([0-2]\d)|(3[0-1]))\d{3}';
    protected $IPv4Exp = '(?=(\b|\D))(((\d{1,2})|(1\d{1,2})|(2[0-4]\d)|(25[0-5]))\.){3}((\d{1,2})|(1\d{1,2})|(2[0-4]\d)|(25[0-5]))(?=(\b|\D))';
    protected $IPv6Exp = '([\\da-fA-F]{1,4}:){7}([\\da-fA-F]{1,4})';
    protected $mobilePhoneExp = '(?:(?:\+|00)?86[- ]?)?0?1[3-57-9][0-9]{9}';
    protected $telephoneExp = '(:?(?:010|02\d{1}|0[3-9]\d{2})-\d{7,9}(?:-\d+)?)|(:?400(-\d{3,4}){2})';


    /**
     * @param $obj
     * @param $pattern
     * @return bool
     */
    public function isMatch($obj, $pattern)
    {
        if (preg_match($pattern, $obj)) {
            return true;
        }
        return false;
    }

    /**
     * @param $obj
     * @param $pattern
     * @return array
     */
    public function pickUp($obj, $pattern)
    {
        $matches = [];
        $ok = preg_match_all($pattern, $obj, $matches);
        return $ok ? $matches[0] : [];
    }

    /**
     * 包裹正则表达式
     * @param string $p 匹配模式
     * @param string $o 附加修饰
     * @return string
     */
    public function pattern($p, $o = '')
    {
        return '/' . $p . '/' . $o;
    }

    /**
     * 包裹成头尾匹配的正则表达式,
     * @param string $p 匹配模式
     * @param string $o 附加修饰
     * @return string
     */
    public function patternPackES($p, $o = '')
    {
        return $this->pattern('^' . $p . '$', $o);
    }

    /**
     * 包裹成尾匹配的正则表达式
     * @param string $p 匹配模式
     * @param string $o 附加修饰
     * @return string
     */
    public function patternPackE($p, $o = '')
    {
        return $this->pattern($p . '$', $o);
    }

    /**
     * 包裹成头匹配的正则表达式
     * @param string $p 匹配模式
     * @param string $o 附加修饰
     * @return string
     */
    public function patternPackS($p, $o = '')
    {
        return $this->pattern('^' . $p, $o);
    }
}