<?php
/**
 * Created by PhpStorm.
 * User: anthony
 * Date: 2019-06-11 14:55
 */

namespace matchYou\human;


use matchYou\Match;

class IDCard extends Match
{
    protected static $idCard = '/[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0-2]\d)|(3[0-1]))\d{3}[\dxX]{1}/';
    protected static $idCard1G = '/[1-9]\d{5}\d{2}((0\d)|(1[0-2]))(([0-2]\d)|(3[0-1]))\d{3}/';

    /**
     * 计算身份证校验码
     * @param $str
     * @return mixed
     */
    private static function calcCheckCode($str)
    {
        $code = ['1','0','X','9','8','7','6','5','4','3','2'];
        $ids = str_split($str);
        if(count($ids) == 17) array_push($ids,"\0");
        $sum = 0;
        for ($i = 2; $i < 19; $i++){
            $index = 18 - $i;
            $a = $ids[$index] == 'X'?10:$ids[$index];
            $sum += $a * bcmod(2<<$i-2,11);
        }
        $y = bcmod($sum, 11);
        $verify = $code[$y];
        return $verify;
    }

    /**
     * 一代身份证
     * @param $str
     * @return bool
     */
    public static function isIDCard1G($str)
    {
        return self::isMatch($str, self::$idCard1G);
    }

    /**
     * 二代身份证
     * @param $str
     * @return bool
     */
    public static function isIDCard2G($str)
    {
        if(self::isMatch($str, self::$idCard)){
            $str = strtoupper($str);
            $security = substr($str, 17, 1);
            $verify = self::calcCheckCode($str);
            if($verify != $security){
                return false;
            }
            return true;
        }else{
            return false;
        }
    }

    /**
     * 转换成二代身份证
     * @param $str
     * @return string
     */
    public static function transferTo2G($str)
    {
        $str = substr_replace($str, '19', 6, 0);
        return $str . self::calcCheckCode($str);
    }

    /**
     * 提取身份证内信息（生日、地区、性别）
     * @param $str
     * @return array|bool
     */
    public static function exportIDCardInfo($str){
        if(self::isIDCard1G($str)) $str = self::transferTo2G($str);
        if(!self::isIDCard2G($str)){
            return false;
        }
        $districtPath = dirname(dirname(__FILE__)).'/data/IDCardDistrict.json';
        $district = json_decode(file_get_contents($districtPath), true);
        $info = [];
        $info['native'] = $district[substr($str,0, 6)][1];
        $info['birthday'] = sprintf("%s-%s-%s", substr($str,6, 4), substr($str,10, 2), substr($str,12, 2));
        $info['police'] = substr($str, 14, 2);
        $info['sex'] = bcmod(substr($str, 16, 1), 2)==1?'男':'女';
        return $info;
    }
}