<?php
	$out = fopen('php://stdout','w');
	echo "请输入用户名：";
	while($in = fopen('php://stdin','r')){
		if(feof($in)) echo "请输入密码：";
		fwrite($out,fgets($in).PHP_EOL);
	}
