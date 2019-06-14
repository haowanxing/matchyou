<?php
/**
 * Created by PhpStorm.
 * User: anthony
 * Date: 2019-06-14 10:07
 */

namespace matchYou\expression;


abstract class ExpAbs
{
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
        return $ok?$matches[0]:[];
    }
    /**
     * 包裹正则表达式
     * @param string $p 匹配模式
     * @param string $o 附加修饰
     * @return string
     */
    public function pattern($p, $o = '')
    {
        return '/'.$p.'/'.$o;
    }

    /**
     * 包裹成头尾匹配的正则表达式,
     * @param string $p 匹配模式
     * @param string $o 附加修饰
     * @return string
     */public function patternPackES($p, $o = '')
    {
        return $this->pattern('^'.$p.'$', $o);
    }

    /**
     * 包裹成尾匹配的正则表达式
     * @param string $p 匹配模式
     * @param string $o 附加修饰
     * @return string
     */
    public function patternPackE($p, $o = '')
    {
        return $this->pattern($p.'$', $o);
    }

    /**
     * 包裹成头匹配的正则表达式
     * @param string $p 匹配模式
     * @param string $o 附加修饰
     * @return string
     */
    public function patternPackS($p, $o = '')
    {
        return $this->pattern('^'.$p, $o);
    }
}