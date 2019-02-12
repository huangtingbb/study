<?php

	include './common.php';
	
	$redis->subscribe(['channel'],'getmessage');


	function getmessage($instance,$channelName,$message){
		echo $channelName.' => '.$message;
	}
