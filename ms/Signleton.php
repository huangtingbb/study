<?php


class Signleton
{

    private static $instance = null;

    protected $work = [1,2,2,3,3,4,5,5];

    private function __construct()
    {
        $this->run();
    }

    public static function getInstance(){
        if (is_null(self::$instance)) return new self;
        else return self::$instance;
    }

    //添加工作
    public function addWork($num){
        array_push($this->work,$num);
    }

    //工作
    public function run(){
        while(true){
            if($num = array_unshift($this->work)){
                echo $num;
                echo date("Y-m-d H:i:s"), "\tcall-----$num", PHP_EOL;
                sleep(6);
            }
        }
    }


}