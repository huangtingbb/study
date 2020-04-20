<?php
	include './common.php';
	$nameList=['apache','alpha','alion','aliyun',
			   'bob','bower','blank','bear','break','bring',
			   'clint','contorll','common','config',
			   'deal','describe','during','docker',
			   'expect','expire','especially','ecshop',
			   'fast','father','fuck','fine','fantastic',
			   'go','get','great','grep',
			   'nginx','vsftpd','php','mysql','redis','lnmp',
			   'excel','word','linux','centos','admin','jquery',
			   'vue','require','object','oop'
			   ];
	$redis->multi();
	foreach($nameList as $name){
		$redis->zadd('names',0,$name);
	}
	$redis->exec();
