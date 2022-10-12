<?php

	include './common.php';
	$data=$_GET;
	echo "<pre>";
	print_r($data);
	$arr=explode(':',$data['goodsname']);
	$seller='user:'.$arr[1];
	$goods=$arr[0];
	$buyer='user:17';
	$price=$data['price'];
	$redis->select(1);
	$end=time()+5;
	while(time()<$end){
		$redis->watch('market',$buyer);//对商场和买家进行观察
		$buyermoney=$redis->hget($buyer,'money');
		if($buyermoney<$price){ //买家余额是否充足
			$redis->unwatch();
			echo "余额不足，请充值";
			return false;
		}
		$redis->multi();//开启事物
		$redis->hincrby($buyer,'money','-'.$price);
		$redis->hincrby($seller,'money',$price);
		$redis->sadd('inventory:17',$goods);
		echo "暂停10秒";
		sleep(10);
		$redis->zrem('market',$data['goodsname']);
		$redis->exec();
		return true;
	}

	echo "购买成功";
