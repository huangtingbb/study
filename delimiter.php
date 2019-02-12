<?php
	function str_format(string $str,int $limit,$delimiter){
		if(!is_string($str)){
			return false;
		}

		$len=strlen($str);
		$queue=[];
		$j=0;
		for($i=$len;$i>0;$i--){
			$j++;
			array_unshift($queue,$str[$i-1]);
			if($j%$limit==0) array_unshift($queue,$delimiter);
		}
		return implode($queue);
	}
	
	function str_format2(string $str,int $limit,$delimter){
		$str_arr=str_split(strrev($str),$limit);
		$str=implode($delimter,$str_arr);
		return strrev($str);
	}

	echo "<pre>";
	$a='1234567890';
	echo str_format($a,3,',');
	echo str_format2($a,3,'.');

	//$start=time();
	//for($i=0;$i<=1000000;$i++){
	//	str_format($a,'3',',');
	//}
	//$time=time()-$start;

	//echo '执行第一个方法的时间'.$time;

	
	//$start2=time();
	//for($i=0;$i<=1000000;$i++){
	//	str_format2($a,'3',',');
	//}
	//$time2=time()-$start2;
	//echo '执行第二个方法的时间:'.$time2;


