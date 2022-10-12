<?php
	function changeVar1(&$a,&$b){
		$a.=','.$b;
		$b=explode(',',$a)[0];
		$a=explode(',',$a)[1];
	}

	function changeVar2(&$a,&$b){
		$a=array($a,$b);
		$b=$a[0];
		$a=$a[1];
	}


	$a='mysql';
	$b='redis';

	$c='mysql';
	$d='myredis';

	changeVar1($a,$b);
	echo $a,$b;

	changeVar2($c,$d);
	echo $c,$d;
