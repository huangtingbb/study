<?php
	$client = new swoole_client(SWOOLE_SOCK_TCP);


		
	$client->connect("47.107.44.128",9501,1) or die("ERROR:{$client->errMsg}");
	$client->send('hello');
	$msg = $client->recv();
	echo $msg;
