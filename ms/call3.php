<?php
const INTERVAL = 2;

$redis = new \Redis();
$redis->connect('47.107.44.128',6380);
$redis->auth('ljstu_redis2019');
echo $redis->get('test');

function call(){
    global $fp_w ,$fp_r ,$fp_lock,$i,$exec_time,$file_lock;
    flock($fp_w,LOCK_EX);
    fputs($fp_w,$i++.PHP_EOL);
    flock($fp_w,LOCK_UN);

    while(true){}
}

function main(){
    if(rand(1,10) % 2 == 0){
        $randoms = [2,4,6,8];
        $key = array_rand($randoms);
        $seconds = $randoms[$key] / 2;
        for ($start = 0 ; $start < $seconds * 2 ;$start++){
            echo date("Y-m-d H:i:s")," [trigger:continue {$seconds} seconds] ",PHP_EOL;
            usleep(500);
            call();
        }
    }else{
        sleep(INTERVAL);
        echo date("Y-m-d H:i:s")," [trigger:interval]",PHP_EOL;
        call();
    }
}

while (true) {
    main();
}

