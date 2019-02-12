<?php
	/**
	*
	*排序
	*/
	include './common.php';
	$time=time();
	$last_week=$time-7*24*60*60;
	$article_ids=$redis->zRevRangeByScore('article_voted',$time,0,['limit'=>[0,2]]);
	print_r($article_ids);
