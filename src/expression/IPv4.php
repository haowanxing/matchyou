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
    /**
     * @param $obj
     * @return bool
     */
    public function match($obj)
    {
        return $this->isMatch($obj, $this->patternPackES($this->IPv4Exp));
    }

    /**
     * @param $obj
     * @return array
     */
    public function extract($obj)
    {
        return $this->pickUp($obj, $this->pattern($this->IPv4Exp));
    }
}