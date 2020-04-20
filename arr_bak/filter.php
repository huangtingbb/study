<?

	$a=[
		'first'=>1,
		'now'=>'',
		'any'=>[
			'more'=>'',
			'he'=>'',
			'a'=>'1'
		],
	];

	$b=array_filter($a,function($value,$key){
		if(is_array($value)){
				print_r(array_filter($value));
			return array_filter($value);	
		}else if($value){
			return $value;
		}
	},ARRAY_FILTER_USE_BOTH);
	print_r($b);
	print_r(array_filter($a));
