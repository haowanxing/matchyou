<?php
/**
 * IPv6匹配
 * User: anthony
 * Date: 2019-06-14 11:42
 */

namespace matchYou\expression;


use matchYou\CanExtracting;
use matchYou\CanMatching;
use matchYou\common\Tool;

class IPv6 extends ExpAbs implements CanMatching, CanExtracting
{
    private $exp = '([\\da-fA-F]{1,4}:){7}([\\da-fA-F]{1,4})';

    /**
     * @param $str
     * @return bool
     */
    public function match($str)
    {
        $idx = strpos($str, '::');
        if ($idx === false){
            return $this->isMatch($str, $this->patternPackES($this->exp));
        }else{
            // there is two "::"
            if($idx !== strrpos($str, '::')){
                return false;
            }
            $items = explode('::', $str);
            $item0 = explode(':', $items[0]);
            $item1 = explode(':', $items[1]);
            if(count($item0) + count($item1) > 7){
                return false;
            }
            foreach ($item0 as $item){
                if (!Tool::isHex($item, 4)){
                    return false;
                }
            }
            foreach ($item1 as $item){
                if (!Tool::isHex($item, 4)){
                    return false;
                }
            }
        }
        return true;
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