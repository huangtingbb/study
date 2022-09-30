<?php
const INTERVAL = 2;
$file_lock = __DIR__."/file.lock";
$work_file = __DIR__."/work";
if (!file_exists($work_file)) touch($work_file);
if (!file_exists($file_lock)) touch($file_lock);

global $fp,$i,$exec_time,$file_lock;
$fp_w = fopen($work_file,"a");
$fp_r = fopen($work_file,"r+");
$fp_lock = fopen($file_lock,"a+");
$i = 1;
function call(){
    global $fp_w ,$fp_r ,$fp_lock,$i,$exec_time,$file_lock;
    flock($fp_w,LOCK_EX);
    fputs($fp_w,$i++.PHP_EOL);
    flock($fp_w,LOCK_UN);

    while(true){
        echo "尝试资源...";
        if(flock($fp_lock,LOCK_EX)){
            echo "获取资源...";
            //如果里面没有值
            if(!fgets($fp_lock)){
                 echo date("Y-m-d H:i:s"),"\tcall-----",time(),PHP_EOL;
            }else{
                $exec_time = fgets($fp_lock);
                while(true){
                    echo "等待执行时间...";
                    if(time() == $exec_time){
                        echo date("Y-m-d H:i:s"),"\tcall----",time(),PHP_EOL;
                        break;
                    }
                }
            }
            //执行完之后6秒中再执行
            $exec_time = time()+6;
            file_put_contents($file_lock,$exec_time);
            flock($fp_lock,LOCK_UN);
            echo "释放资源...";
            break;
        }
    }
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

while (true){
    main();
}