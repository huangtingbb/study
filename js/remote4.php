<?php
	$callback=$_GET['callback'];

	$data=[
		['name'=>'雷霆沙赞','price'=>24.5],
		['name'=>'复仇者联盟4:终局之战','price'=>59]

	];

	$data=json_encode($data);
	$script=<<<Script
		$callback($data);
Script;

	echo $script;
