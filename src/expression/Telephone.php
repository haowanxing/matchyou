<?php
/**
 * 电话号匹配
 * User: anthony
 * Date: 2019-06-14 13:30
 */

namespace matchYou\expression;


use matchYou\CanExtracting;
use matchYou\CanMatching;

class Telephone extends ExpAbs implements CanMatching, CanExtracting
{
    /**
     * @param $obj
     * @return bool
     */
    public function match($obj)
    {
        return $this->isMatch($obj, $this->patternPackES($this->telephoneExp));
    }

    /**
     * @param $obj
     * @return array
     */
    public function extract($obj)
    {
        return $this->pickUp($obj, $this->pattern($this->telephoneExp));
    }
}