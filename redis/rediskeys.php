<?php
	$redis=new redis();
	$redis->connect('127.0.0.1',6379);
	$keyList=$redis->keys('*');
	echo "<pre>";
	print_r($keyList);
