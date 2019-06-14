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
    private $exp = '(?:(?:http:\/\/)|(?:https:\/\/)|(?:ftp:\/\/))?[a-zA-Z0-9](?:[a-zA-Z0-9\-]{0,61}[a-zA-Z0-9]?\.)+[a-zA-Z]{2,6}[a-zA-Z0-9\-\.\!\*\'\(\);_\:@&=+$,\/\?#\[\]]*';

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