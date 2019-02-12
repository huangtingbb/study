<?php
	$str="www.php.cn";
	echo strrev(str_replace('www','',$str)),"<br>";

	echo strrev(substr($str,3)),"<br>";

	echo strrev(ltrim($str,'w')),"<br>";

	echo strrev(substr($str,strrpos($str,'w')+1)),"<br>";
	
	echo strrev(strstr($str,'.'));
