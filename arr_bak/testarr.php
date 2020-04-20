<?php
	$arr=['a'=>1,'2'=>'b',3=>'c','d'=>4];
	$randValue=array_rand($arr);
	echo $randValue;

	$randArr=array_rand($arr,3);
	print_r($randArr);



	$arr=[1,2,3];
	$arr=array_merge($arr,$arr,$arr);
	print_r($arr);
