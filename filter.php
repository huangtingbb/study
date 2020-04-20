<?php
	$a="13207lj@qq.com123";

	$a=filter_var($a,FILTER_VALIDATE_EMAIL);

	$b="1234564564@";

	$b=filter_var($b,FILTER_VALIDATE_EMAIL);

	echo $a;
	echo $b;
