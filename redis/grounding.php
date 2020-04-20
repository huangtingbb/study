<?php
	
	include './common.php';
	$redis->select(1);
	$data=$_POST;
	print_r($data);
	//die('数据格式不对');
	$redis->watch('inventory:'.$data['userid']);
	$redis->multi();
	$goodsname=$data['goodsname'].':'.$data['userid'];
	echo $goodsname."<br>";
	$is_exists=$redis->sismember('inventory:'.$data['userid'],$data['goodsname']);
	$redis->zadd('market',$data['price'],$goodsname);
	if($is_exists){
		$redis->srem('inventory:'.$data['userid'],$data['goodsname']);	
	}else{
		$redis->discard();
	}
	print_r($redis->exec());
	echo "添加商品成功";
	//header("location:market.php");
	
