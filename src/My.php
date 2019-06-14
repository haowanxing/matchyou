<?php
/**
 * 匹配器
 * User: anthony
 * Date: 2019-06-14 09:31
 */

namespace matchYou;


use Exception;

class My
{

    /**
     * @param $className
     * @return CanMatching
     * @throws Exception
     */
    public static function matcher($className)
    {
        $matcher =  new $className;
        if($matcher instanceof CanMatching){
            return $matcher;
        }
        throw new Exception(sprintf('%s is not a %s', $className, CanMatching::class));
    }

    /**
     * @param $className
     * @return CanExtracting
     * @throws Exception
     */
    public static function extractor($className)
    {
        $matcher =  new $className;
        if($matcher instanceof CanExtracting){
            return $matcher;
        }
        throw new Exception(sprintf('%s is not a %s', $className, CanExtracting::class));
    }
}