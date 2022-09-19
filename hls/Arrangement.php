<?php

namespace hls;
class Arrangement
{
    private $n;//总数

    private $data;//初始化数据

    private $count;//全排列的总数

    private $ans = [];//全排列

    public function __construct($n)
    {
        $this->n = $n;
        $this->data = range(1,$this->n);
        $this->perm($this->data,0,$this->n-1);
    }

    /**
     * 获取n的全排列
     * @param $data
     * @param int $k
     * @param int $n
     */
    private function perm($data,$k,$n){
        $this->count = 1;
        if ($k == $n){
            $this->ans[] = $data;
        }
        for ($i = $k;$i<=$n;$i++){
            $this->swap($data,$i,$k);
            $this->perm($data,$k+1,$n);
            $this->swap($data,$i,$k);
        }
    }

    private function swap(&$data,$i,$j){
        $tmp = $data[$i];
        $data[$i] = $data[$j];
        $data[$j] = $tmp;
    }

    /**
     * 获取一个排列的逆序数
     * @param $number_arr
     * @return int
     */
    public function getInversionNumber($number_arr){
        $len = count($number_arr) - 1;
        $number = 0;
        for($i = 0;$i<=$len;$i++){
            for ($j = $i+1;$j<=$len;$j++){
                if ($number_arr[$i] > $number_arr[$j]) $number++;
            }
        }
        return $number;
    }

    /**
     * 返回全排列
     * @return array
     */
    public function getFullArrangement(){
        return $this->ans;
    }

    /**
     * 打印全排列
     */
    public function print(){
        foreach ($this->ans as $row){
            echo implode(" ",$row),"\n";
        }
    }

}