<?php

	$a=[
		'a'=>1,
		'b'=>'',
		'c'=>[
			'a'=>'',
			'b'=>1,
			'c'=>''
		]
	];

	$b=array_map(function($value){
		if(is_array($value)){
			return array_filter($value);
		}else if($value){
			return $value;
		}
	},$a);

	print_r(array_filter($b));
