<?php
	$data=$_POST;
	$prifx=$data['name'];	
	if($prifx==''){
		echo "[]";
		return;	
	}
	$charsets='`abcdefghijklmnopqrstuvwxyz{';
	$prifx--;	
	$prifx_last=$prifx;
	$limit=substr($prifx,strlen($prifx)-1,1);
	$limit++;
	$prifx_next=substr($prifx,0,strlen($prifx)-1).$limit;
	
	include './common.php';
		$redis->zadd('names',0,$prifx_last);
		$redis->zadd('names',0,$prifx_next);

		$start=$redis->zrank('names',$prifx_last);
		$end=$redis->zrank('names',$prifx_next);
		$redis->zrem('names',$prifx_last);
		$redis->zrem('names',$prifx_next);
	
		$nameList=$redis->zrange('names',$start,$end-2);
	echo json_encode($nameList);


