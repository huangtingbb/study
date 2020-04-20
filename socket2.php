<?php
	$socket = socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
	socket_connect($socket,"127.0.0.1","9501");
	$message = "hello";
	socket_write($socket,$message,strlen($message));
	$recv = socket_read($socket,1024);
	echo $recv;

