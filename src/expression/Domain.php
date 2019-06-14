<?php
/**
 * 域名匹配
 * User: anthony
 * Date: 2019-06-14 09:36
 */

namespace matchYou\expression;


use matchYou\CanExtracting;
use matchYou\CanMatching;

class Domain extends ExpAbs implements CanMatching, CanExtracting
{
    private $exp = '[a-zA-Z0-9](?:[a-zA-Z0-9\-]{0,61}[a-zA-Z0-9]?\.)+[a-zA-Z]{2,6}';

    /**
     * @param $obj
     * @return bool
     */
    public function match($obj)
    {
        return $this->isMatch($obj, $this->patternPackES($this->exp));
    }

    public function extract($obj)
    {
        return $this->pickUp($obj, $this->pattern($this->exp));
    }
}