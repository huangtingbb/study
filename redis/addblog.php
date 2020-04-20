<?php
	include './common.php';

	$id=$redis->get('article_id');
	$redis->incr('article_id');//article_id自增;
	$article_id='article:'.$id;//新的散列表
	$blogdata=['title'=>'learn redis 2','content'=>'this is my second time ','pubtime'=>time(),'author'=>'lj'];
	$ret=$redis->hmset($article_id,$blogdata);
	if($ret) echo "添加成功";
	else echo "添加失败";
	
	
