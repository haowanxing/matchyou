<?php
/**
 * Created by PhpStorm.
 * User: anthony
 * Date: 2019-06-14 09:37
 */

namespace matchYou;


interface CanMatching
{

    /**
     * @param $obj
     * @return bool
     */
    public function match($obj);
}