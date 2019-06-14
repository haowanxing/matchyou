<?php
/**
 * IPv4匹配
 * User: anthony
 * Date: 2019-06-14 11:42
 */

namespace matchYou\expression;


use matchYou\CanExtracting;
use matchYou\CanMatching;

class IPv4 extends ExpAbs implements CanMatching, CanExtracting
{
    private $exp = '(?=(\b|\D))(((\d{1,2})|(1\d{1,2})|(2[0-4]\d)|(25[0-5]))\.){3}((\d{1,2})|(1\d{1,2})|(2[0-4]\d)|(25[0-5]))(?=(\b|\D))';

    /**
     * @param $obj
     * @return bool
     */
    public function match($obj)
    {
        return $this->isMatch($obj, $this->patternPackES($this->exp));
    }

    /**
     * @param $obj
     * @return array
     */
    public function extract($obj)
    {
        return $this->pickUp($obj, $this->pattern($this->exp));
    }
}