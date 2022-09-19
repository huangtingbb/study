<?php


class Snowflake
{
    const TIME = 1629860155919;

//    $bit = 0 1001101 11101111 00110011 01101010 10000 010 11000 00100001;


    const WORKER_ID_BITS = 5 ; //机器标志位数
    const DATA_CENTER_ID_BITS = 5 ;//数据中心标识位数
    const SEQUENCE_BITS = 11; //毫秒内自增

    private $worker_id;//工作机器
    private $data_center_id; //数据id
    private $sequence;//毫秒内序列

    private $max_worker_id = 31;
    private $max_data_center_id = 31;

    private $worker_id_shift = self::SEQUENCE_BITS; // 12位
    private $data_center_id_shift = self::SEQUENCE_BITS + self::WORKER_ID_BITS; //17位
    private $timestamp_shift = self::SEQUENCE_BITS + self::WORKER_ID_BITS + self::DATA_CENTER_ID_BITS; //22位
    private $sequence_mask = 4095;

    private $last_timestamp = -1;

    public function __construct($worker_id , $data_center_id , $sequence = 0)
    {
        if ($worker_id > $this->max_worker_id || $worker_id < 0){
            throw new Exception("工作机器id范围不符");
        }
        if($data_center_id > $this->max_data_center_id || $data_center_id < 0){
            throw  new Exception("数据中心id范围不符");
        }
        $this->worker_id = $worker_id;
        $this->data_center_id = $data_center_id;
        $this->sequence = $sequence;
    }

    public function nextId(){
        $timestamp = $this->getMicrotime();
        if($timestamp < $this->last_timestamp){
            throw new Exception("当前时间不符，无法再生成当前时间的id");
        } else if($timestamp == $this->last_timestamp){
            $this->sequence = ($this->sequence + 1) & $this->sequence_mask;
            if($this->sequence == 0){
                $timestamp = $this->nextMillis($this->last_timestamp);
            }
        }else{
            $this->sequence = 0;
        }
        $this->last_timestamp = $timestamp;


        return (($timestamp - self::TIME) << $this->timestamp_shift) |
            ($this->data_center_id << $this->data_center_id_shift) |
            ($this->worker_id << $this->worker_id_shift) |
            $this->sequence;
    }

    public function nextMillis($last_timestamp){
        $timestamp= $this->getMicrotime();
        while($timestamp <= $last_timestamp){
            $timestamp = $this->getMicrotime();
        }
        return $timestamp;
    }

    private function getMicrotime(){
        return floor(microtime(true) * 1000);
    }
}

$id = new Snowflake(1,1);
$id2 = new Snowflake(2,1);
$id3= new Snowflake(2,2);
while(true) {
    //decbin(5);将数字转成字节字符串
    echo "id :",($id->nextId()),"\n";
    echo "id2:",($id2->nextId()),"\n";
//    echo "id3:",($id3->nextId()),"\n";
}