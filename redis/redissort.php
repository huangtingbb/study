<?php

	include './common.php';

	$redis->select(1);
	$redis->rpush('list:test',23,15,22,17,35);
	$arr=$redis->sort('list:test',['sort'=>'desc']);
	print_r($arr);
