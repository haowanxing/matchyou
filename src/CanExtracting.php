<?php
/**
 * Created by PhpStorm.
 * User: anthony
 * Date: 2019-06-14 09:40
 */

namespace matchYou;


interface CanExtracting
{
    /**
     * @param $obj
     * @return array
     */
    public function extract($obj);
}