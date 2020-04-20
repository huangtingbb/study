<?php
	include './common.php';
	$redis->select(1);
	$redis->zadd('zset:test',12,'var1');
	$redis->zadd('zset:test',24,'var3');
	$redis->zadd('zset:test',23,'var2',8,'var0');
	$a=$redis->zincrby('zset:test',2,'var0');
	echo $a."<br>";
	print_r($redis->zrange('zset:test',0,-1,true));
	$redis->zadd('zset:test2',1,'var1');
	$redis->zadd('zset:test2',3,'var3');
	$redis->zadd('zset:test2',6,'var2',8,'var0');
	$redis->zunion('zset:union',['zset:test','zset:test2'],[2,5],'max');//并集运算;
	echo "<pre>";
	echo "<br>";
	echo "合并之后的有序集合为：";
	print_r($redis->zrange('zset:union',0,-1));
	$redis->close();
