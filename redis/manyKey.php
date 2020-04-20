<?php
require_once "./common.php";
$key = "test_many_key:";

for($i = 1;$i<=500000;$i++){
	$redis->set($key.$i,1);
}

