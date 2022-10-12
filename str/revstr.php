<?php
function revstr($str,&$rev_str=''){
	$len=strlen($str);	
	if($len==0) return $rev_str;
	$rev_str.= $str[$len-1];					       
	echo $rev_str;
	revstr(substr($str,0,$len-1));
}
									    
 $a='123456' ;
 $a=revstr($a);									   
 echo $a;
