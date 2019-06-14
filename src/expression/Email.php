<?php
/**
 * 邮箱匹配
 * User: anthony
 * Date: 2019-06-14 11:28
 */

namespace matchYou\expression;


use matchYou\CanExtracting;
use matchYou\CanMatching;

class Email extends ExpAbs implements CanMatching, CanExtracting
{
    private $exp = '[A-Za-z0-9\-\._\u4e00-\u9fa5]+@[a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9]?\.)+[a-zA-Z]{2,6}';

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
     * @return array|mixed
     */
    public function extract($obj)
    {
        return $this->pickUp($obj, $this->pattern($this->exp));
    }
}