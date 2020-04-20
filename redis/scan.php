<?php

	$redis = new \Redis();
	$redis->connect('118.25.5.242');
	$redis->auth('77Dianjing!');
	$cursor = null;
	$res = 0 ;
	$redis->setOption(Redis::OPT_SCAN,Redis::SCAN_RETRY);
	$arr = [];
	while($res = $redis->scan($cursor,'77dj_app:activity:4:*:135')){
		//echo $cursor,PHP_EOL;
		if(is_array($res)){
			foreach($res as $v){
				array_push($arr,$v);
			}
		}
	}
	var_dump($arr);
	//var_dump($redis->keys('*'));//keys 会阻塞数据库，如果数据库中的键特别多，这个命令会有很大的安全隐患
