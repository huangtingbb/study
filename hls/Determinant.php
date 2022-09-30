<?php

namespace hls;
require_once "Arrangement.php";
class Determinant
{

    private $data = [];
    private $n = 0;//n阶

    private $arrangement = null;


    public function __construct($data)
    {
        if (!is_array($data)) throw new \Exception("该数据不是行列式");
        //检查行与列是否相同 n阶行列式
        $this->n = count($data);
        foreach ($data as $row){
            if (count($row) != $this->n) throw new \Exception("该数据不是行列式");
        }
        $this->arrangement = new Arrangement($this->n);
        $this->initData($data);
    }

    private function initData($data){
        $r = 1;
        foreach ($data as $row){
            $j = 1;
            $row_data = [];
            foreach ($row as $col){
                $row_data[$j++] = $col;
            }
            $this->data[$r++] = $row_data;
        }
    }

    public function print(){
        foreach ($this->data as $row){
            echo "|";
            foreach ($row as $key => $value){
                echo $value;
                if ($key == $this->n) echo "|";
                else echo "\t";
            }
            echo "\n";
        }
    }

    public function getResult(){
        $result = 0;
        $full_arr = $this->arrangement->getFullArrangement();
        foreach ($full_arr as $col_arr){
            $inversion_num = $this->arrangement->getInversionNumber($col_arr);
            $s = 1;
            foreach ($col_arr as $key=>$col){
                echo "row :".($key+1).",col:$col ";
                echo $this->data[$key+1][$col] ," ";
                $s *= $this->data[$key+1][$col];
                echo " ",$s;
            }
            echo "\n";
            if ($inversion_num % 2 == 0) $result += $s;
            else $result -= $s;
        }
        return $result;
    }

    /**
     * 获取n的全排列
     */
    public function getFullArrangement(){
        $this->arrangement->print();
    }

    public function getArrangment(){
        return $this->arrangement;
    }
}
$data = [
    [1,-1,2,-3,1],
    [-3,3,-7,9,-5],
    [2,0,4,-2,1],
    [3,-5,7,-14,6],
    [4,-4,10,-10,2],
];
$data2 = [
    [1,2,3,4],
    [2,45,7,8],
    [1,23,5,6],
    [2,4,6,8]
];
$data3 = [
    [2,0,1],
    [1,-4,-1],
    [-1,8,3]
];
$hls = new Determinant($data3);
echo $hls->getResult();
