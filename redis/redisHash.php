<?php
	$redis=new redis();
	$redis->connect('127.0.0.1');
	$arr=['realname'=>'liujin','birthday'=>mktime(0,0,0,1997,5,4),'email'=>'1029148937@qq.com','mobile'=>'13207171044'];
	$redis->hmset('无耻老贼',$arr);
	echo "无耻老贼的详细信息：";
	echo "<br>";
	echo "\t真实姓名：".$redis->hget('无耻老贼','realname');
	echo "<br>\t生日: ".date('Y-m-d',$redis->hget('无耻老贼','birthday'));
	echo "<br>\t邮箱: ".$redis->hget('无耻老贼','email');
	echo "<br>\t联系电话: ".$redis->hget('无耻老贼','mobile');
	$redis->close();

