<?php
	include './common.php';
	$visitHistory=[];
	for($i=1;$i<=30;$i++){
		$key='item'.$i;
		$value=$i;
		$redis->zadd('viewed:token1',$i,$key);
	}

