<?php
require_once __DIR__."/Signleton.php";
const INTERVAL = 2;
global $i;
$i = 1;
function call(){
    global $i;
    Signleton::getInstance()->addWork($i);
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