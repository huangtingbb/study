<?php
	$redis=new Redis();
	$redis->connect('127.0.0.1',6379);
	$redis->set('lj','liujin');
	echo "Stored string in redis: ".$redis->get('lj')."<br>";
	$redis->set('lj','liujin2');
	echo "Stored string in redis: ".$redis->get('lj')."<br>";
	$redis->append('lj','love ht');
	echo "Stored string in redis: ".$redis->get('lj')."<br>";
	$redis->setrange('lj',16,'bb');
	echo "Stored string in redis: ".$redis->get('lj')."<br>";

	$redis->incr('rediskey');

	echo "<br>".$redis->get('rediskey');
	$redis->incr('rediskey',5);
	echo "<br>+5之后的值".$redis->get('rediskey');
