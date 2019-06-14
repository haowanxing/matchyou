<?php
/**
 * URL匹配
 * User: anthony
 * Date: 2019-06-14 11:42
 */

namespace matchYou\expression;


use matchYou\CanExtracting;
use matchYou\CanMatching;

class URL extends ExpAbs implements CanMatching, CanExtracting
{
    /**
     * @param $obj
     * @return bool
     */
    public function match($obj)
    {
        return $this->isMatch($obj, $this->patternPackES($this->urlExp));
    }

    public function extract($obj)
    {
        return $this->pickUp($obj, $this->pattern($this->urlExp));
    }
}