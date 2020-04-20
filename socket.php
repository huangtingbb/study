<?php
		$socket=socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
//        list($addr,$port) = explode(':',$socket_config['url']);
        $addr = "127.0.0.1";
        $port = "9501";
        $bool = socket_connect($socket,$addr,$port);
		if($bool) echo "链接成功";
		socket_write($socket,12,2);
        //$a = socket_send($socket,json_encode(['token'=>'648a96108a731b135cc0eb798fce712be085b5c2']),1024,MSG_OOB);
        $str = [];
//        $b = socket_recvmsg($socket,$str,MSG_OOB);
        socket_recvfrom($socket, $buf, 12, 0, $addr, $port);
        echo $buf;
