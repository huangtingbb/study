<?php

	$a = $_GET['a'] ?? 2222192456123.21435;

	function format($num){
		@list($int,$float)=explode('.',$num);
		$int_arr = str_split(strrev($int),3);
		$str = strrev(implode(',',$int_arr));
		$float = $folat ?? '00';
		return $str.'.'.$float;
	}

	echo $a;
	$b = format($a);
	echo $b;
