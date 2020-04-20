<?php

require_once "./common.php";

$key = "test_big_key";

for($i = 1;$i<=500000;$i++){
	$redis->hset($key,$i,$i);
}


