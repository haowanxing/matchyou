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

    /**
     * @param $obj
     * @return bool
     */
    public function match($obj)
    {
        return $this->isMatch($obj, $this->patternPackES($this->emailExp,'u'));
    }

    /**
     * @param $obj
     * @return array|mixed
     */
    public function extract($obj)
    {
        return $this->pickUp($obj, $this->pattern($this->emailExp,'u'));
    }
}