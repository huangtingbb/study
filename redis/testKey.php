<?php 

require_once "./common.php";

function getMillisecond() {
	list($t1, $t2) = explode(' ', microtime());
	return (float)sprintf('%.0f', (floatval($t1) + floatval($t2)) * 1000);
}

//添加50W个string键
include "./manyKey.php";

$start_time = getMillisecond();
for($i = 1;$i<=500000;$i++){
	$redis->get("test_many_key:".$i);
}
$end_time = getMillisecond();
$time = $end_time - $start_time ;
echo "执行50W次读操作 （50w个key的redis）耗时 ",$time," 毫秒",PHP_EOL;

for($i = 1;$i<=500000;$i++){
	$redis->del("test_many_key:".$i);
}

$keys = $redis->keys("*");
echo "删掉50W string key,还剩 ".count($keys) ." 个键",PHP_EOL;

//添加一个50W element 的hash
include "./bigKey.php";


$start_time = getMillisecond();
for($i = 0; $i <= 500000 ; $i++){
	$redis->hget("test_big_key",$i);
}
$end_time = getMillisecond();
$time = $end_time - $start_time ;

echo "执行50W次读hashMap中的键操作，耗时 ",$time," 毫秒",PHP_EOL;

$redis->del("test_big_key");
