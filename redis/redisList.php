<?php
	$redis=new Redis();
	$redis->connect('127.0.0.1',6379);
	$redis->lpush('list1','lj');
	$redis->lpush('list1','ht');
	$redis->rpush('list1','last');
	$redis->lpush('list1','sgz');
	$redis->lpush('list1','sgz2');
	$arr=$redis->lrange('list1',0,3);
	print_r($arr);
	echo "获取第3个元素：".$redis->lindex('list1',2)."<br>";
	$redis->ltrim('list1',1,2);
	echo "修剪过后的list值：";
	print_r($redis->lrange('list1',0,-1));
