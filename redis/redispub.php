<?php

	include "./common.php";
	$redis->publish('channel1','hello world1');
	$redis->publish('channel1','hello world2');
	$redis->publish('channel1','hello world3');
	$redis->close();
