<?php
/**
 * 身份证匹配
 * User: anthony
 * Date: 2019-06-14 09:36
 */

namespace matchYou\expression;


use matchYou\CanExtracting;
use matchYou\CanMatching;

class IDCard extends ExpAbs implements CanMatching, CanExtracting
{
    private $idCard2G = '[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0-2]\d)|(3[0-1]))\d{3}[\dxX]{1}';
    private $idCard1G = '[1-9]\d{5}\d{2}((0\d)|(1[0-2]))(([0-2]\d)|(3[0-1]))\d{3}';

    /**
     * @param $str
     * @return bool
     */
    public function match($str)
    {
        if($this->isIDCard1G($str)){
            $str = $this->transferTo2G($str);
        }
        return $this->isIDCard2G($str);
    }

    /**
     * @param $obj
     * @return array
     */
    public function extract($obj)
    {
        $ret = [];
        $one = $this->pickUp($obj, $this->pattern($this->idCard1G));
        $two = $this->pickUp($obj, $this->pattern($this->idCard2G));
        $data = array_merge($one, $two);
        if(!empty($data)){
            foreach ($data as $v){
                $row = ['id'=>$v];
                $info = $this->exportIDCardInfo($v);
                if ($info){
                    $row = array_merge($row, $info);
                }
                array_push($ret, $row);
            }
        }
        return $ret;
    }

    public function isIDCard1G($str){
        return $this->isMatch($str, $this->pattern($this->idCard1G));
    }

    public function isIDCard2G($str){
        if($this->isMatch($str, $this->pattern($this->idCard2G))){
            $str = strtoupper($str);
            $security = substr($str, 17, 1);
            $verify = $this->calcCheckCode($str);
            if($verify != $security){
                return false;
            }
            return true;
        }else{
            return false;
        }
    }


    /**
     * 计算身份证校验码
     * @param $str
     * @return mixed
     */
    public function calcCheckCode($str)
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
     * 转换成二代身份证
     * @param $str
     * @return string
     */
    public function transferTo2G($str)
    {
        $str = substr_replace($str, '19', 6, 0);
        return $str . $this->calcCheckCode($str);
    }


    /**
     * 提取身份证内信息（生日、地区、性别）
     * @param $str
     * @return array|bool
     */
    public function exportIDCardInfo($str){
        if($this->isIDCard1G($str)) $str = $this->transferTo2G($str);
        if(!$this->isIDCard2G($str)){
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